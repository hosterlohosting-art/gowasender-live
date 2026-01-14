<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Bulkrequest;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\Message\Media\LinkID;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\Button;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\ButtonAction;
use App\Models\User;
use App\Models\ChatMessage;
use App\Models\App;
use App\Models\CloudApi;
use App\Models\Reply;
use App\Traits\Cloud;
use App\Traits\Notifications;
use DB;
use Exception;

class BulkController extends Controller
{
    use Cloud;
    use Notifications;

    // --- 1. SEND MESSAGE API (Standard) ---
    public function submitRequest(Bulkrequest $request)
    {
        $user = User::where('status', 1)->where('authkey', $request->authkey)->first();
        $app = App::where('key', $request->appkey)->first();

        if (!$user || !$app)
            return response()->json(['error' => 'Invalid Auth'], 401);

        return response()->json(['message' => 'Request Processed'], 200);
    }

    // --- 2. HELPER: SAVE CHAT ---
    public function saveMessageToUserChat($userChat, $message, $type, $id = '')
    {
        if ($userChat) {
            $history = json_decode($userChat->message_history, true) ?? [];
            $history[] = [
                'chatID' => $id,
                'message' => $message,
                'timestamp' => now()->toDateTimeString(),
                'status' => 'sent',
                'type' => $type,
            ];
            $userChat->message_history = json_encode($history);
            $userChat->save();
        }
    }

    // --- 3. THE BRAIN (WEBHOOK) ---
    public function webHook(Request $request, $cloudapi_id)
    {
        $cloudapi_id = str_replace('cloudapi_', '', $cloudapi_id);
        $cloudapi = CloudApi::where('uuid', $cloudapi_id)->first();

        if (!$cloudapi)
            return response()->json(['error' => 'Invalid API ID'], 404);

        if ($request->input('hub_mode') === 'subscribe') {
            return $request->input('hub_challenge');
        }

        try {
            $payload = $request->all();
            $changeValue = $payload['entry'][0]['changes'][0]['value'] ?? null;

            if (isset($changeValue['statuses']))
                return response()->json(['message' => 'Status'], 200);
            if (!isset($changeValue['messages']))
                return response()->json(['message' => 'No msg'], 200);

            $messageEntry = $changeValue['messages'][0];
            $request_from = $messageEntry['from'];
            $message_id = $messageEntry['id'];
            $type = $messageEntry['type'];
            $message = '';

            // Extract Message Content
            if ($type == 'text')
                $message = $messageEntry['text']['body'];
            elseif ($type == 'button')
                $message = $messageEntry['button']['text'];
            elseif ($type == 'interactive') {
                $message = $messageEntry['interactive']['button_reply']['title']
                    ?? $messageEntry['interactive']['list_reply']['title']
                    ?? 'Interactive';
            } else
                $message = $type;

            // --- A. SAVE INCOMING MESSAGE ---
            $userChat = ChatMessage::where('phone_number', $request_from)
                ->where('cloudapi_id', $cloudapi->id)->first();

            if ($userChat) {
                $this->saveMessageToUserChat($userChat, $message, 'received', $message_id);
            } else {
                $newUserChat = new ChatMessage();
                $newUserChat->phone_number = $request_from;
                $newUserChat->cloudapi_id = $cloudapi->id;
                $newUserChat->message_history = json_encode([
                    [
                        'chatID' => $message_id,
                        'message' => $message,
                        'timestamp' => now()->toDateTimeString(),
                        'type' => 'received',
                        'status' => 'read'
                    ]
                ]);
                $newUserChat->save();
                $userChat = $newUserChat;
            }

            // --- B. CREATE SYSTEM NOTIFICATION ---
            $notification = new \App\Models\Notification();
            $notification->user_id = $cloudapi->user_id;
            $notification->title = __("New WhatsApp Message from ") . $request_from;
            $notification->comment = 'whatsapp-message'; // Category for sidebar/logic
            $notification->url = "/user/cloudapi/chats/" . $cloudapi->uuid;
            $notification->seen = 0;
            $notification->save();

            // Setup API
            $whatsapp_app_cloud_api = new WhatsAppCloudApi([
                'from_phone_number_id' => $cloudapi->phone_number_id,
                'access_token' => $cloudapi->access_token,
            ]);

            // ====================================================
            // 1. FLOW BUILDER ENGINE (CHAIN REACTION)
            // ====================================================
            $flows = DB::table('flows')->where('user_id', $cloudapi->user_id)->where('status', 1)->get();
            $flowTriggered = false;

            foreach ($flows as $flow) {
                $flowData = json_decode($flow->flow_data, true);
                if (!$flowData || !isset($flowData['drawflow']['Home']['data']))
                    continue;

                $nodes = $flowData['drawflow']['Home']['data'];
                $startNode = null;

                // Find START Node
                foreach ($nodes as $key => $node) {
                    if ($node['name'] === 'start') {
                        $startNode = $node;
                        break;
                    }
                }

                if ($startNode) {
                    // Check Keyword Match
                    $keyword = $startNode['data']['keyword'] ?? '';
                    $condition = $startNode['data']['condition'] ?? 'equal';
                    $isMatch = false;

                    if (!empty($keyword)) {
                        if ($condition === 'equal' && strtolower(trim($message)) == strtolower(trim($keyword))) {
                            $isMatch = true;
                        } elseif ($condition === 'contains' && stripos($message, $keyword) !== false) {
                            $isMatch = true;
                        }
                    }

                    if ($isMatch) {
                        $flowTriggered = true;
                        // Start the Chain Reaction
                        $this->processFlowChain($startNode, $nodes, $request_from, $whatsapp_app_cloud_api, $userChat);
                        break;
                    }
                }
            }

            // ====================================================
            // 2. SIMPLE CHATBOT FALLBACK
            // ====================================================
            if (!$flowTriggered) {
                $replies = Reply::where('cloudapi_id', $cloudapi->id)->get();
                $sent = false;

                foreach ($replies as $reply) {
                    $should_send = false;
                    if ($reply->match_type == 'equal') {
                        if (strtolower(trim($message)) == strtolower(trim($reply->keyword)))
                            $should_send = true;
                    } else {
                        if (stripos($message, $reply->keyword) !== false)
                            $should_send = true;
                    }

                    if ($should_send) {
                        if ($reply->reply_type == 'text') {
                            $whatsapp_app_cloud_api->sendTextMessage($request_from, $reply->reply);
                            $this->saveMessageToUserChat($userChat, $reply->reply, 'sent', 'bot_' . time());
                            $sent = true;
                        }
                        break;
                    }
                }

                if (!$sent) {
                    $defaultReply = Reply::where('cloudapi_id', $cloudapi->id)->where('keyword', 'default')->first();
                    if ($defaultReply) {
                        $whatsapp_app_cloud_api->sendTextMessage($request_from, $defaultReply->reply);
                        $this->saveMessageToUserChat($userChat, $defaultReply->reply, 'sent', 'bot_' . time());
                    }
                }
            }

            return response()->json(['message' => 'Processed'], 200);

        } catch (\Exception $e) {
            Log::error('Webhook Error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Error'], 200);
        }
    }

    // --- RECURSIVE FLOW PROCESSOR ---
    private function processFlowChain($currentNode, $allNodes, $to, $api, $userChat)
    {

        $connections = $currentNode['outputs']['output_1']['connections'] ?? [];

        foreach ($connections as $connection) {
            $nextNodeId = $connection['node'];
            $nextNode = $allNodes[$nextNodeId] ?? null;

            if ($nextNode) {
                // 1. SLEEP: The Secret Sauce!
                // Waits 1 second before sending the next message to prevent order mix-ups
                sleep(1);

                // 2. EXECUTE
                $this->executeNode($nextNode, $to, $api, $userChat);

                // 3. LOOP
                $this->processFlowChain($nextNode, $allNodes, $to, $api, $userChat);
            }
        }
    }

    // --- EXECUTE NODE LOGIC ---
    private function executeNode($node, $to, $api, $userChat)
    {
        try {
            $nodeType = $node['name'];
            $data = $node['data'];

            // 1. TEXT MESSAGE
            if ($nodeType === 'text') {
                $text = $data['message'] ?? '...';
                $api->sendTextMessage($to, $text);
                $this->saveMessageToUserChat($userChat, $text, 'sent', 'flow_' . time());
            }

            // 2. IMAGE MESSAGE
            elseif ($nodeType === 'image') {
                $url = $data['image_url'] ?? null;
                $caption = $data['caption'] ?? '';
                if ($url) {
                    $link_id = new LinkID($url);
                    $api->sendImage($to, $link_id, $caption);
                    $this->saveMessageToUserChat($userChat, 'Image Sent', 'sent', 'flow_' . time());
                }
            }

            // 3. BUTTONS (Standard)
            elseif ($nodeType === 'buttons') {
                $header = $data['header'] ?? '';
                $body = $data['description'] ?? 'Please choose an option';
                $buttons = [];

                if (!empty($data['btn1']))
                    $buttons[] = new Button('btn1', $data['btn1']);
                if (!empty($data['btn2']))
                    $buttons[] = new Button('btn2', $data['btn2']);
                if (!empty($data['btn3']))
                    $buttons[] = new Button('btn3', $data['btn3']);

                if (count($buttons) > 0) {
                    $action = new ButtonAction($buttons);
                    $api->sendButton($to, $body, $action, $header);
                    $this->saveMessageToUserChat($userChat, "[Buttons] $body", 'sent', 'flow_' . time());
                }
            }

            // 4. SUPER RICH CARD (Fix for "Meta Card")
            elseif ($nodeType === 'meta_card') {
                $title = $data['title'] ?? '';
                $body = $data['description'] ?? 'Check this out';
                $footer = $data['footer'] ?? '';
                $imgUrl = $data['image_url'] ?? null;

                // A. Send Header Image First (Most reliable method)
                if ($imgUrl) {
                    $link_id = new LinkID($imgUrl);
                    $api->sendImage($to, $link_id);
                    sleep(1); // Short pause so image arrives before text
                }

                // B. Send Content + Buttons
                $buttons = [];
                if (!empty($data['btn1']))
                    $buttons[] = new Button('btn1', $data['btn1']);
                if (!empty($data['btn2']))
                    $buttons[] = new Button('btn2', $data['btn2']);
                if (!empty($data['btn3']))
                    $buttons[] = new Button('btn3', $data['btn3']);

                if (count($buttons) > 0) {
                    $action = new ButtonAction($buttons);
                    $api->sendButton($to, $body, $action, $title); // Title acts as Header text
                    $this->saveMessageToUserChat($userChat, "[Card] $title", 'sent', 'flow_' . time());
                } else {
                    // Fallback if no buttons (Send as Text)
                    $msg = "*$title*\n\n$body\n\n_{$footer}_";
                    $api->sendTextMessage($to, $msg);
                    $this->saveMessageToUserChat($userChat, "[Card Text] $title", 'sent', 'flow_' . time());
                }
            }

            // 5. WAIT NODE
            elseif ($nodeType === 'wait') {
                $seconds = intval($data['seconds'] ?? 0); // Corrected key from 'duration' to 'seconds'
                if ($seconds > 0 && $seconds <= 5) {
                    sleep($seconds);
                }
            }

        } catch (\Exception $e) {
            Log::error("Node Execution Failed: " . $e->getMessage());
        }
    }
}