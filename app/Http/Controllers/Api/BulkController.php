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
use App\Models\Device;
use App\Services\ChatbotService;
use App\Traits\Cloud;
use App\Traits\Notifications;
use App\Traits\DeviceTrait;
use DB;
use Exception;

class BulkController extends Controller
{
    use Cloud, Notifications, DeviceTrait;

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
        $gateway_uuid = str_replace(['cloudapi_', 'device_'], '', $cloudapi_id);

        $cloudapi = CloudApi::where('uuid', $gateway_uuid)->first();
        $device = !$cloudapi ? Device::where('uuid', $gateway_uuid)->first() : null;

        if (!$cloudapi && !$device) {
            return response()->json(['error' => 'Invalid Gateway ID'], 404);
        }

        if ($request->input('hub_mode') === 'subscribe') {
            return $request->input('hub_challenge');
        }

        try {
            $payload = $request->all();

            // Handle Unofficial Device Message Payload
            if ($device) {
                // Assuming the node.js server sends a simplified payload
                // Adjust based on your node server's webhook format
                $request_from = $payload['from'] ?? ($payload['data']['from'] ?? null);
                $message = $payload['message'] ?? ($payload['data']['text'] ?? '');
                $message_id = $payload['id'] ?? 'dev_' . time();
                $type = 'text';
            } else {
                // Official Cloud API Payload
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
            }

            if (!$request_from)
                return response()->json(['message' => 'Invalid source'], 200);

            // --- A. SAVE INCOMING MESSAGE ---
            $gateway_id = $cloudapi ? $cloudapi->id : null;
            // Note: If you add device_id to ChatMessage later, use it here.
            // For now, mapping to user chats via phone number.
            $userChat = ChatMessage::where('phone_number', $request_from);
            if ($cloudapi)
                $userChat = $userChat->where('cloudapi_id', $cloudapi->id);
            $userChat = $userChat->first();

            if ($userChat) {
                $this->saveMessageToUserChat($userChat, $message, 'received', $message_id);
            } else {
                $newUserChat = new ChatMessage();
                $newUserChat->phone_number = $request_from;
                if ($cloudapi)
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
            $notification->user_id = $cloudapi ? $cloudapi->user_id : $device->user_id;
            $notification->title = __("New WhatsApp Message from ") . $request_from;
            $notification->comment = 'whatsapp-message';
            $notification->url = $cloudapi ? "/user/cloudapi/chats/" . $cloudapi->uuid : "/user/device";
            $notification->seen = 0;
            $notification->save();

            // --- C. BRAIN ENGINE (Flows / Bot / AI) ---
            $user_id = $cloudapi ? $cloudapi->user_id : $device->user_id;

            // 1. FLOW BUILDER ENGINE
            $flows = DB::table('flows')->where('user_id', $user_id)->where('status', 1)->get();
            $flowTriggered = false;

            // Helper to send reply based on gateway
            $sendReply = function ($to, $msg) use ($cloudapi, $device) {
                if ($cloudapi) {
                    $api = new WhatsAppCloudApi([
                        'from_phone_number_id' => $cloudapi->phone_number_id,
                        'access_token' => $cloudapi->access_token,
                    ]);
                    $api->sendTextMessage($to, $msg);
                } elseif ($device) {
                    $this->sendDeviceMessage($device->uuid, $to, $msg);
                }
            };

            foreach ($flows as $flow) {
                $flowData = json_decode($flow->flow_data, true);
                $nodes = $flowData['drawflow']['Home']['data'] ?? [];
                $startNode = collect($nodes)->firstWhere('name', 'start');

                if ($startNode) {
                    $keyword = $startNode['data']['keyword'] ?? '';
                    $condition = $startNode['data']['condition'] ?? 'equal';
                    $isMatch = false;

                    if (!empty($keyword)) {
                        if ($condition === 'equal' && strtolower(trim($message)) == strtolower(trim($keyword)))
                            $isMatch = true;
                        elseif ($condition === 'contains' && stripos($message, $keyword) !== false)
                            $isMatch = true;
                    }

                    if ($isMatch) {
                        $flowTriggered = true;
                        if ($cloudapi) {
                            $whatsapp_api = new WhatsAppCloudApi([
                                'from_phone_number_id' => $cloudapi->phone_number_id,
                                'access_token' => $cloudapi->access_token,
                            ]);
                            $this->processFlowChain($startNode, $nodes, $request_from, $whatsapp_api, $userChat);
                        } else {
                            // Unofficial Device Flow support could be added here if processFlowChain is made gateway-agnostic
                            $sendReply($request_from, "Flow triggered but full device chain not yet implemented.");
                        }
                        break;
                    }
                }
            }

            // 2. SIMPLE CHATBOT & AI FALLBACK
            if (!$flowTriggered) {
                $replies = Reply::where('user_id', $user_id);
                if ($cloudapi)
                    $replies = $replies->where('cloudapi_id', $cloudapi->id);
                $replies = $replies->get();

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
                        // Priority 1: AI Agent (If API Key is set in rule)
                        if (!empty($reply->api_key)) {
                            $chatbotService = new ChatbotService();
                            $behavior = $reply->reply ?? 'You are a helpful assistant.';
                            $aiResponse = $chatbotService->generateResponse($message, $reply->api_key, $behavior);
                            $sendReply($request_from, $aiResponse);
                            $this->saveMessageToUserChat($userChat, $aiResponse, 'sent', 'ai_' . time());
                            $sent = true;
                        }
                        // Priority 2: Static Text Reply
                        elseif ($reply->reply_type == 'text' && !empty($reply->reply)) {
                            $sendReply($request_from, $reply->reply);
                            $this->saveMessageToUserChat($userChat, $reply->reply, 'sent', 'bot_' . time());
                            $sent = true;
                        }
                        break;
                    }
                }

                if (!$sent) {
                    $defaultQuery = Reply::where('user_id', $user_id)->where('keyword', 'default');
                    if ($cloudapi)
                        $defaultQuery = $defaultQuery->where('cloudapi_id', $cloudapi->id);
                    $defaultReply = $defaultQuery->first();

                    if ($defaultReply) {
                        if (!empty($defaultReply->api_key)) {
                            $chatbotService = new ChatbotService();
                            $behavior = $defaultReply->reply ?? 'You are a helpful assistant.';
                            $aiResponse = $chatbotService->generateResponse($message, $defaultReply->api_key, $behavior);
                            $sendReply($request_from, $aiResponse);
                            $this->saveMessageToUserChat($userChat, $aiResponse, 'sent', 'ai_' . time());
                        } else {
                            $sendReply($request_from, $defaultReply->reply);
                            $this->saveMessageToUserChat($userChat, $defaultReply->reply, 'sent', 'bot_' . time());
                        }
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