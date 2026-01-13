<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CloudApi;
use App\Models\Template;
use App\Models\ChatMessage;
use App\Models\Notification;
use App\Models\User;
use App\Models\Contact;
use DB;
use Auth;
use App\Traits\Cloud;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;

class ChatController extends Controller
{
    use Cloud;

    public function chats($id)
    {
        $cloudapi = CloudApi::where('user_id', Auth::id())->where('status', 1)->where('uuid', $id)->first();
        abort_if(empty($cloudapi), 404);
        $templates = Template::where('user_id', Auth::id())->where('status', 1)->latest()->get();
        return view('user.chats.list2', compact('cloudapi', 'templates'));
    }

    public function chatHistory($id)
    {
        $cloudapi = CloudApi::where('user_id', Auth::id())->where('status', 1)->where('uuid', $id)->first();

        abort_if(empty($cloudapi), 404);

        $whatsapp_cloud_api = new WhatsAppCloudApi([
            'from_phone_number_id' => $cloudapi->phone_number_id,
            'access_token' => $cloudapi->access_token,
        ]);

        $chatHistory = ChatMessage::where('cloudapi_id', $cloudapi->id)->get();

        // You can manipulate or format the chat history data as needed
        $formattedHistory = $chatHistory->map(function ($item) use ($whatsapp_cloud_api) {
            $contact = Contact::where('user_id', Auth::id())->where('phone', $item->phone_number)->first();
            $name = $contact ? $contact->name : null;

            $messageHistory = json_decode($item->message_history, true);

            $lastReceivedDeliveredMessage = null;

            foreach ($messageHistory as &$message) {
                if ($message['type'] === 'received' && isset($message['status']) && $message['status'] === 'delivered') {
                    $lastReceivedDeliveredMessage = $message;
                }
            }

            // Check if there is a last message to mark as read
            try {
                if ($lastReceivedDeliveredMessage !== null) {
                    $whatsapp_cloud_api->markMessageAsRead($lastReceivedDeliveredMessage['chatID']);

                    // Update the status to 'seen'
                    $lastReceivedDeliveredMessage['status'] = 'seen';
                }
            } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                // Handle the exception or log it
                error_log("Error marking message as read: " . $e->getMessage());
            }

            // Convert the modified message history back to JSON
            $item->message_history = json_encode($messageHistory);

            // Save the changes to the ChatMessage model
            $item->save();

            $notification = Notification::where('user_id', Auth::id())->where('comment', 'user-message')->first();
            if ($notification) {
                $notification->seen = 1;
                $notification->save();
            }

            return [
                'id' => $item->id,
                'cloudapi_id' => $item->cloudapi_id,
                'phone_number' => $item->phone_number,
                'message_history' => json_decode($item->message_history),
                'name' => $name,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
            ];
        });

        return response()->json($formattedHistory);
    }



    public function sendMessage(Request $request, $id)
    {
        $cloudapi = CloudApi::where('user_id', Auth::id())
            ->where('status', 1)
            ->where('uuid', $id)
            ->first();

        $userChat = ChatMessage::where('phone_number', $request->receiver)
            ->where('cloudapi_id', $cloudapi->id)
            ->first();

        $whatsapp_cloud_api = new WhatsAppCloudApi([
            'from_phone_number_id' => $cloudapi->phone_number_id,
            'access_token' => $cloudapi->access_token,
        ]);

        if (getUserPlanData('messages_limit') == false) {
            return response()->json([
                'message' => __('Maximum Monthly Messages Limit Exceeded')
            ], 401);
        }

        abort_if(empty($cloudapi), 404);

        $validated = $request->validate([
            'receiver' => 'required|max:20',
            'message' => 'required'
        ]);

        try {
            // 1. Send Message to WhatsApp API
            $response = $whatsapp_cloud_api->sendTextMessage($request->receiver, $request->message, true);

            // 2. Log the transaction
            $logs["user_id"] = Auth::id();
            $logs["cloudapi_id"] = $cloudapi->id;
            $logs["from"] = $device->phone ?? null;
            $logs["to"] = $request->receiver; // Fixed typo (was reciver)
            $logs["template_id"] = $template->id ?? null;
            $logs["type"] = "single-send";
            $this->saveLog($logs);

            // 3. Save Message to Database (Moved this UP so it actually runs)
            if ($userChat) {
                $messageHistory = json_decode($userChat->message_history, true) ?? [];
                $chatID = uniqid('chat_', true);
                $newMessage = [
                    'chatID' => $chatID,
                    'message' => $request->message,
                    'timestamp' => now()->toDateTimeString(),
                    'type' => 'sent',
                ];

                $messageHistory[] = $newMessage;

                // Update the message history in the database
                $userChat->message_history = json_encode($messageHistory);
                $userChat->save();
            } else {
                $newUserChat = new ChatMessage();
                $newUserChat->phone_number = $request->receiver;
                $newUserChat->cloudapi_id = $cloudapi->id;
                $newUserChat->message_history = json_encode([
                    [
                        'message' => $request->message,
                        'timestamp' => now()->toDateTimeString(),
                        'type' => 'sent',
                    ]
                ]);
                $newUserChat->save();
            }

            // 4. Return success ONLY AFTER saving to DB
            return response()->json([
                'message' => __('Message sent successfully..!!'),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Request Failed',
            ], 401);
        }
    }

    public function clearMessages(Request $request, $id)
    {
        $cloudapi = CloudApi::where('user_id', Auth::id())
            ->where('status', 1)
            ->where('uuid', $id)
            ->first();

        if (!$cloudapi) {
            return response()->json(['status' => 'error', 'message' => 'Cloud API not found'], 404);
        }

        $chatMessage = ChatMessage::where('cloudapi_id', $cloudapi->id)
            ->where('phone_number', $request->phone)
            ->first();

        if (!$chatMessage) {
            return response()->json(['status' => 'error', 'message' => 'No messages found for the specified phone number'], 404);
        }

        $messageHistory = json_decode($chatMessage->message_history, true);

        if (is_array($messageHistory) && !empty($messageHistory)) {
            $firstMessage = array_shift($messageHistory); // Keep the first message

            // Re-encode the remaining messages
            $chatMessage->message_history = json_encode([$firstMessage]);
            $chatMessage->save();

            return response()->json(['status' => 'success', 'message' => 'Messages cleared successfully, except the first one']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'No messages to clear'], 404);
        }
    }
}