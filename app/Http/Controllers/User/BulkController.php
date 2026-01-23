<?php

namespace App\Http\Controllers\User;

use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Row;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Section;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Action;
use Netflie\WhatsAppCloudApi\Message\Media\LinkID;
use Netflie\WhatsAppCloudApi\Message\Media\MediaObjectID;
use Netflie\WhatsAppCloudApi\Message\Template\Component;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Smstransaction;
use App\Models\Smstesttransactions;
use App\Http\Requests\Bulkrequest;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\App;
use App\Models\CloudApi;
use App\Models\Contact;
use App\Models\Template;
use App\Models\Group;
use Carbon\Carbon;
use App\Traits\Cloud;
use Http;
// use App\Models\Device;
// use App\Traits\DeviceTrait;
use Auth;
use Str;
class BulkController extends Controller
{
    use Cloud;
    public $whatsapp_app_cloud_api;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Smstransaction::where('user_id', Auth::id())->with('cloudapi')->with('template')->where('type', 'bulk-message')->latest()->paginate(20);
        $total = Smstransaction::where('user_id', Auth::id())->where('type', 'bulk-message')->count();
        $today_transaction = Smstransaction::where('user_id', Auth::id())
            ->where('type', 'bulk-message')
            ->whereRaw('date(created_at) = ?', [Carbon::now()->format('Y-m-d')])
            ->count();
        $last30_messages = Smstransaction::where('user_id', Auth::id())
            ->where('type', 'bulk-message')
            ->where('created_at', '>', now()
                ->subDays(30)
                ->endOfDay())
            ->count();

        $cloudapis = CloudApi::where('user_id', Auth::id())->where('status', 1)->latest()->get();
        // removed unofficial device logic
        $templates = Template::where('user_id', Auth::id())->where('status', 1)->latest()->get();
        $groups = Group::where('user_id', Auth::id())->whereHas('groupcontacts')->latest()->get();

        return view('user.whatsapp.bulk.index', compact('posts', 'total', 'today_transaction', 'last30_messages', 'cloudapis', 'templates', 'groups'));
    }

    public function create()
    {
        $cloudapis = CloudApi::where('user_id', Auth::id())->where('status', 1)->latest()->get();
        // $devices = Device::where('user_id', Auth::id())->latest()->get();
        $groups = Group::where('user_id', Auth::id())->with('contacts')->whereHas('contacts')->latest()->get();

        return view('user.whatsapp.bulk.multiple', compact('cloudapis', 'groups'));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|numeric',
            'message' => 'required|max:1000',
            'cloudapi' => 'required',
        ]);

        $phone = str_replace('+', '', $request->phone);
        $contact = Contact::where('user_id', Auth::id())->where('phone', $phone)->first();
        $user = User::where('id', Auth::id())->first();


        // Official Cloud API Logic
        $cloudapi = CloudApi::where('user_id', Auth::id())->where('status', 1)->findorFail($request->cloudapi);
        $userChat = ChatMessage::where('phone_number', $phone)->where('cloudapi_id', $cloudapi->id)->first();
        $whatsapp_app_cloud_api = new WhatsAppCloudApi([
            'from_phone_number_id' => $cloudapi->phone_number_id,
            'access_token' => $cloudapi->access_token,
        ]);

        $message = $this->formatText($request['message'], $contact, $user);
        try {
            $response = $whatsapp_app_cloud_api->sendTextMessage($phone, $request['message']);
            $logs['user_id'] = Auth::id();
            $logs['cloudapi_id'] = $cloudapi->id;
            $logs['from'] = $cloudapi->phone ?? null;
            $logs['to'] = $phone;
            $logs['type'] = 'bulk-message';
            $this->saveLog($logs);
            $this->saveMessageToUserChat($userChat, $request['message'], 'plain-text', $phone, $cloudapi->id);

            return response()->json([
                'message' => __('Message sent successfully..!!'),
            ], 200);
        } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
            $errorDetails = $e->getMessage(); // This gets the JSON string
            $errorObject = json_decode($errorDetails); // Decode into an object

            // Now, access the nested message property
            $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
            return response()->json([
                'message' => $errorMessage
            ], 500);
        }
    }


    //creating record
    public function createTransaction($arr)
    {
        $trans = new Smstransaction;
        foreach ($arr as $key => $value) {
            $trans->$key = $value;
        }
        $trans->save();

        return $trans;
    }

    public function saveMessageToUserChat($userChat, $templateName, $type, $request_from, $templateCloudId)
    {
        if ($userChat) {
            $userChatMessages = json_decode($userChat->message_history, true) ?? [];
            $chatID = uniqid('chat_', true);
            $newMessage = [
                'chatID' => $chatID,
                'message' => 'Bulk Message-[' . $type . ']:' . $templateName,
                'timestamp' => now()->toDateTimeString(),
                'type' => 'sent',
            ];

            $userChatMessages[] = $newMessage;

            // Update the message history in the database
            $userChat->message_history = json_encode($userChatMessages);
            $userChat->save();
        } else {
            $chatID = uniqid('chat_', true);
            $newUserChat = new ChatMessage();
            $newUserChat->phone_number = $request_from;
            $newUserChat->cloudapi_id = $templateCloudId;
            $newUserChat->message_history = json_encode([
                [
                    'chatID' => $chatID,
                    'message' => 'Bulk Message-[' . $type . ']:' . $templateName,
                    'timestamp' => now()->toDateTimeString(),
                    'type' => 'sent',
                ]
            ]);
            $newUserChat->save();

        }
    }

    public function submitRequest(Bulkrequest $request)
    {
        //dd($request);

        $user = User::where('status', 1)->where('authkey', $request->authkey)->first();

        $app = App::where('key', $request->appkey)->whereHas('cloudapi')->with('cloudapi')->where('status', 1)->first();




        if ($user == null || $app == null) {
            return response()->json(['error' => 'Invalid Auth and AppKey'], 401);
        }

        if (getUserPlanData('messages_limit') == false) {
            return response()->json([
                'message' => __('Maximum Monthly Messages Limit Exceeded')
            ], 401);
        }

        $whatsapp_app_cloud_api = new WhatsAppCloudApi([
            'from_phone_number_id' => $app->cloudapi->phone_number_id,
            'access_token' => $app->cloudapi->access_token,
        ]);

        if (!empty($request->template_id)) {
            $template = Template::where('user_id', $user->id)->where('uuid', $request->template_id)->where('status', 1)->first();
            if (empty($template)) {
                return response()->json(['error' => 'Template Not Found'], 401);
            }

            if (isset($template->body)) {
                $body = $template->body;
            } else {
                return response()->json(['error' => 'Template Not Found'], 401);
            }
            $type = $template->type;

            if ($type == 'plain-text') {
                $data = $body;
                $desc = $body['text'];
                try {
                    $response = $whatsapp_app_cloud_api->sendTextMessage($request->to, $desc);
                    $logs['user_id'] = Auth::id();
                    $logs['cloudapi_id'] = $app->cloudapi_id;
                    $logs['from'] = $app->cloudapi->phone ?? null;
                    $logs['to'] = $request->to;
                    $logs['type'] = 'bulk-message';
                    $this->saveLog($logs);
                    return response()->json([
                        'message_status' => 'Success',
                        'data' => [
                            'from' => $app->cloudapi->phone ?? null,
                            'to' => $request->to,
                            'status_code' => 200,
                        ]
                    ], 200);
                } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                    $errorDetails = $e->getMessage(); // This gets the JSON string
                    $errorObject = json_decode($errorDetails); // Decode into an object

                    // Now, access the nested message property
                    $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                    return response()->json([
                        'message' => $errorMessage
                    ], 500);
                }
            }

            if ($template->type == 'text-with-list') {
                $data = $body;

                // Extract the required information
                $title = $data['title'];
                $text = $data['text'];
                $footer = $data['footer'];
                $sectionsData = $data['sections'];

                $rows = [];
                $a = 0;
                foreach ($sectionsData[0]['rows'] as $row) {
                    $rowId = $a;
                    $title = $row['title'];
                    $description = $row['description'] ?? null;
                    $rows[] = new Row($rowId, $title, $description);
                    $a++;
                }

                $sections = [new Section($sectionsData[0]['title'], $rows)];
                $action = new Action($data['buttonText'], $sections);

                // Send the list message using the transformed data
                try {
                    $response = $whatsapp_app_cloud_api->sendList(
                        $request->to,
                        $data['title'],
                        $data['text'],
                        $data['footer'],
                        $action
                    );
                    $logs['user_id'] = Auth::id();
                    $logs['cloudapi_id'] = $app->cloudapi_id;
                    $logs['from'] = $app->cloudapi->phone ?? null;
                    $logs['to'] = $request->to;
                    $logs['type'] = 'bulk-message';
                    $this->saveLog($logs);

                    return response()->json([
                        'message_status' => 'Success',
                        'data' => [
                            'from' => $app->cloudapi->phone ?? null,
                            'to' => $request->to,
                            'status_code' => 200,
                        ]
                    ], 200);

                } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                    $errorDetails = $e->getMessage(); // This gets the JSON string
                    $errorObject = json_decode($errorDetails); // Decode into an object

                    // Now, access the nested message property
                    $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                    return response()->json([
                        'message' => $errorMessage
                    ], 500);
                }
            }
            if ($template->type == 'text-with-media') {
                $data = $body;

                if (isset($data['image']) && !empty($data['image']['url'])) {
                    $link_id = new LinkID($data['image']['url']);
                    try {
                        $response = $whatsapp_app_cloud_api->sendImage($request->to, $link_id);
                        $logs['user_id'] = Auth::id();
                        $logs['cloudapi_id'] = $app->cloudapi_id;
                        $logs['from'] = $app->cloudapi->phone ?? null;
                        $logs['to'] = $request->to;
                        $logs['type'] = 'bulk-message';
                        $this->saveLog($logs);
                        return response()->json([
                            'message_status' => 'Success',
                            'data' => [
                                'from' => $app->cloudapi->phone ?? null,
                                'to' => $request->to,
                                'status_code' => 200,
                            ]
                        ], 200);
                    } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                        $errorDetails = $e->getMessage(); // This gets the JSON string
                        $errorObject = json_decode($errorDetails); // Decode into an object

                        // Now, access the nested message property
                        $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                        return response()->json([
                            'message' => $errorMessage
                        ], 500);
                    }
                } elseif (isset($data['document']) && !empty($data['document']['url'])) {
                    $document_caption = $data['caption'];
                    $document_url = $data['document']['url'];
                    $document_name = basename($document_url);
                    $link_id = new LinkID($document_url);
                    try {
                        $response = $whatsapp_app_cloud_api->sendDocument($request->to, $link_id, $document_name, $document_caption);
                        $logs['user_id'] = Auth::id();
                        $logs['cloudapi_id'] = $app->cloudapi_id;
                        $logs['from'] = $app->cloudapi->phone ?? null;
                        $logs['to'] = $request->to;
                        $logs['type'] = 'bulk-message';
                        $this->saveLog($logs);
                        return response()->json([
                            'message_status' => 'Success',
                            'data' => [
                                'from' => $app->cloudapi->phone ?? null,
                                'to' => $request->to,
                                'status_code' => 200,
                            ]
                        ], 200);

                    } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                        $errorDetails = $e->getMessage(); // This gets the JSON string
                        $errorObject = json_decode($errorDetails); // Decode into an object

                        // Now, access the nested message property
                        $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                        return response()->json([
                            'message' => $errorMessage
                        ], 500);
                    }
                }


            }

            if ($template->type == 'text-with-location') {
                $data = $body;
                $latitude = $data['location']['degreesLatitude'];
                $longitude = $data['location']['degreesLongitude'];
                try {
                    $response = $whatsapp_app_cloud_api->sendLocation($request->to, (float) $latitude, (float) $longitude, '', $template->title);
                    $logs['user_id'] = Auth::id();
                    $logs['cloudapi_id'] = $app->cloudapi_id;
                    $logs['from'] = $app->cloudapi->phone ?? null;
                    $logs['to'] = $request->to;
                    $logs['type'] = 'bulk-message';
                    $this->saveLog($logs);
                    return response()->json([
                        'message_status' => 'Success',
                        'data' => [
                            'from' => $app->cloudapi->phone ?? null,
                            'to' => $request->to,
                            'status_code' => 200,
                        ]
                    ], 200);
                } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                    $errorDetails = $e->getMessage(); // This gets the JSON string
                    $errorObject = json_decode($errorDetails); // Decode into an object

                    // Now, access the nested message property
                    $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                    return response()->json([
                        'message' => $errorMessage
                    ], 500);
                }
            }
            if ($template->type == 'meta-template') {
                $templateName = $body['name'];
                if (!empty($body['components'][0]['example']['header_text'][0]) || !empty($body['components'][0]['example']['body_text'][0][0])) {
                    return response()->json([
                        'message' => __('Dynamic Template Found, Bulk Message not supported for this Item'),
                    ], 401);
                } else {
                    try {
                        $response = $whatsapp_app_cloud_api->sendTemplate($request->to, $templateName, $body['language']);
                        $logs['user_id'] = Auth::id();
                        $logs['cloudapi_id'] = $app->cloudapi_id;
                        $logs['from'] = $app->cloudapi->phone ?? null;
                        $logs['to'] = $request->to;
                        $logs['type'] = 'bulk-message';
                        $this->saveLog($logs);
                        return response()->json([
                            'message_status' => 'Success',
                            'data' => [
                                'from' => $app->cloudapi->phone ?? null,
                                'to' => $request->to,
                                'status_code' => 200,
                            ]
                        ], 200);
                    } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                        $errorDetails = $e->getMessage(); // This gets the JSON string
                        $errorObject = json_decode($errorDetails); // Decode into an object

                        // Now, access the nested message property
                        $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                        return response()->json([
                            'message' => $errorMessage
                        ], 500);
                    }
                }
            }
        } else {
            $text = $this->formatText($request->message);
            $body['text'] = $text;
            $whatsapp_app_cloud_api->sendTextMessage($request->to, $body['text']);
            return response()->json([
                'message_status' => 'Success',
                'data' => [
                    'from' => $app->cloudapi->phone ?? null,
                    'to' => $request->to,
                    'status_code' => 200,
                ]
            ], 200);
        }

        if (!isset($body)) {
            return response()->json(['error' => 'Request Failed'], 401);
        }

    }

    public function sendBulkToContacts($id, $group_id, $cloudapi_id, $headerParm = null, $body = null)
    {
        $headerParm = urldecode($headerParm);

        if ($id == 'custom-text') {
            $template = new Template();
            $template->id = 0;
            $template->title = 'Plain Text';
            $template->type = 'plain-text';
            $template->body = ['text' => urldecode($body)];
        } else {
            $template = Template::where('user_id', Auth::id())->findOrFail($id);
        }

        $contacts = Contact::where('user_id', Auth::id())->whereHas('groupcontacts', function ($q) use ($group_id) {
            return $q->where('group_id', $group_id);
        })->get();

        $templates = Template::where('user_id', Auth::id())->where('status', 1)->latest()->get();

        $cloudapi = CloudApi::where('user_id', Auth::id())->where('status', 1)->where('uuid', $cloudapi_id)->first();
        if (!$cloudapi) {
            abort(404, 'Selected Official API not found.');
        }

        $cloudapis = CloudApi::where('user_id', Auth::id())->where('status', 1)->latest()->get();
        // $devices = Device::where('user_id', Auth::id())->where('status', 1)->latest()->get();

        return view('user.template.bulk', compact('template', 'templates', 'contacts', 'cloudapi', 'cloudapis', 'headerParm', 'body'));
    }




    public function sendMessageToContact(Request $request)
    {
        if (getUserPlanData('messages_limit') == false) {
            return response()->json([
                'message' => __('Maximum Monthly Messages Limit Exceeded')
            ], 401);
        }

        if ($request->template == 0) {
            $template = new Template();
            $template->id = 0;
            $template->type = 'plain-text';
            $template->body = ['text' => $request->body];
        } else {
            $template = Template::where('user_id', Auth::id())->findOrFail($request->template);
        }

        $cloudapi = CloudApi::where('user_id', Auth::id())->where('status', 1)->find($request->cloudapi);
        $contact = Contact::where('user_id', Auth::id())->findOrFail($request->contact);
        $user = User::where('id', Auth::id())->first();


        abort_if(empty($cloudapi), 404);

        $userChat = ChatMessage::where('phone_number', $contact->phone)->where('cloudapi_id', $cloudapi->id)->first();

        $whatsapp_app_cloud_api = new WhatsAppCloudApi([
            'from_phone_number_id' => $cloudapi->phone_number_id,
            'access_token' => $cloudapi->access_token,
        ]);


        if (isset($template->body)) {
            $body = $template->body;
        } else {
            return response()->json(['error' => 'Template Not Found'], 401);
        }
        $type = $template->type;

        if ($type == 'plain-text') {
            $data = $body;
            $formatText = $request->body; // Replaced text from view
            $desc = $formatText;
            try {
                $response = $whatsapp_app_cloud_api->sendTextMessage($contact->phone, $desc);
                $logs['user_id'] = Auth::id();
                $logs['cloudapi_id'] = $cloudapi->id;
                $logs['from'] = $cloudapi->phone ?? null;
                $logs['to'] = $contact->phone;
                $logs['type'] = 'bulk-message';
                $logs['template_id'] = $template->id > 0 ? $template->id : null;
                $this->saveLog($logs);
                $this->saveMessageToUserChat($userChat, $desc, $type, $contact->phone, $cloudapi->id);
                return response()->json([
                    'message_status' => 'Success',
                    'data' => [
                        'from' => $cloudapi->phone ?? null,
                        'to' => $contact->phone,
                        'status_code' => 200,
                    ]
                ], 200);

            } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                $errorDetails = $e->getMessage(); // This gets the JSON string
                $errorObject = json_decode($errorDetails); // Decode into an object

                // Now, access the nested message property
                $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                return response()->json([
                    'message' => $errorMessage
                ], 500);
            }
        }

        if ($template->type == 'text-with-list') {
            $data = $body;

            // Extract the required information
            $title = $data['title'];
            $text = $data['text'];
            $footer = $data['footer'];
            $sectionsData = $data['sections'];

            $rows = [];
            $a = 0;
            foreach ($sectionsData[0]['rows'] as $row) {
                $rowId = $a;
                $title = $row['title'];
                $description = $row['description'] ?? null;
                $rows[] = new Row($rowId, $title, $description);
                $a++;
            }

            $sections = [new Section($sectionsData[0]['title'], $rows)];
            $action = new Action($data['buttonText'], $sections);

            // Send the list message using the transformed data
            try {
                $response = $whatsapp_app_cloud_api->sendList(
                    $contact->phone,
                    $data['title'],
                    $data['text'],
                    $data['footer'],
                    $action
                );
                $logs['user_id'] = Auth::id();
                $logs['cloudapi_id'] = $cloudapi->id;
                $logs['from'] = $cloudapi->phone ?? null;
                $logs['to'] = $contact->phone;
                $logs['type'] = 'bulk-message';
                $logs['template_id'] = $template->id ?? null;
                $this->saveLog($logs);
                $this->saveMessageToUserChat($userChat, $template->title, $type, $contact->phone, $cloudapi->id);

                return response()->json([
                    'message_status' => 'Success',
                    'data' => [
                        'from' => $cloudapi->phone ?? null,
                        'to' => $contact->phone,
                        'status_code' => 200,
                    ]
                ], 200);


            } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                $errorDetails = $e->getMessage(); // This gets the JSON string
                $errorObject = json_decode($errorDetails); // Decode into an object

                // Now, access the nested message property
                $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                return response()->json([
                    'message' => $errorMessage
                ], 500);
            }
        }
        if ($template->type == 'text-with-media' || $template->type == 'text-with-image') {
            $data = $body;

            if (isset($data['image']) && !empty($data['image']['url'])) {
                $link_id = new LinkID($data['image']['url']);
                try {
                    $response = $whatsapp_app_cloud_api->sendImage($contact->phone, $link_id);
                    $logs['user_id'] = Auth::id();
                    $logs['cloudapi_id'] = $cloudapi->id;
                    $logs['from'] = $cloudapi->phone ?? null;
                    $logs['to'] = $contact->phone;
                    $logs['type'] = 'bulk-message';
                    $logs['template_id'] = $template->id ?? null;
                    $this->saveLog($logs);
                    $this->saveMessageToUserChat($userChat, $template->title, $template->type, $contact->phone, $cloudapi->id);
                    return response()->json([
                        'message_status' => 'Success',
                        'data' => [
                            'from' => $cloudapi->phone ?? null,
                            'to' => $contact->phone,
                            'status_code' => 200,
                        ]
                    ], 200);
                } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                    return response()->json([
                        'message' => __('Message Not sent successfully..!!')
                    ], $e->httpStatusCode());
                }
            } elseif (isset($data['document']) && !empty($data['document']['url'])) {
                $document_caption = $data['caption'];
                $document_url = $data['document']['url'];
                $document_name = basename($document_url);
                $link_id = new LinkID($document_url);
                try {
                    $response = $whatsapp_app_cloud_api->sendDocument($contact->phone, $link_id, $document_name, $document_caption);
                    $logs['user_id'] = Auth::id();
                    $logs['cloudapi_id'] = $cloudapi->id;
                    $logs['from'] = $cloudapi->phone ?? null;
                    $logs['to'] = $contact->phone;
                    $logs['type'] = 'bulk-message';
                    $logs['template_id'] = $template->id ?? null;
                    $this->saveLog($logs);
                    $this->saveMessageToUserChat($userChat, $template->title, $template->type, $contact->phone, $cloudapi->id);
                    return response()->json([
                        'message_status' => 'Success',
                        'data' => [
                            'from' => $cloudapi->phone ?? null,
                            'to' => $contact->phone,
                            'status_code' => 200,
                        ]
                    ], 200);

                } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                    $errorDetails = $e->getMessage(); // This gets the JSON string
                    $errorObject = json_decode($errorDetails); // Decode into an object

                    // Now, access the nested message property
                    $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                    return response()->json([
                        'message' => $errorMessage
                    ], 500);
                }
            }


        }

        if ($template->type == 'text-with-location') {
            $data = $body;
            $latitude = $data['location']['degreesLatitude'];
            $longitude = $data['location']['degreesLongitude'];
            try {
                $response = $whatsapp_app_cloud_api->sendLocation($contact->phone, (float) $latitude, (float) $longitude, '', $template->title);
                $logs['user_id'] = Auth::id();
                $logs['cloudapi_id'] = $cloudapi->id;
                $logs['from'] = $cloudapi->phone ?? null;
                $logs['to'] = $contact->phone;
                $logs['type'] = 'bulk-message';
                $logs['template_id'] = $template->id ?? null;
                $this->saveLog($logs);
                $this->saveMessageToUserChat($userChat, $template->title, $template->type, $contact->phone, $cloudapi->id);
                return response()->json([
                    'message_status' => 'Success',
                    'data' => [
                        'from' => $cloudapi->phone ?? null,
                        'to' => $contact->phone,
                        'status_code' => 200,
                    ]
                ], 200);
            } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                $errorDetails = $e->getMessage(); // This gets the JSON string
                $errorObject = json_decode($errorDetails); // Decode into an object

                // Now, access the nested message property
                $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                return response()->json([
                    'message' => $errorMessage
                ], 500);
            }
        }
        if ($template->type == 'meta-template') {
            $templateName = $body['name'];
            $language = $body['language'];
            if (!empty($body['components'][0]['example']['header_text'][0]) || !empty($body['components'][0]['example']['body_text'][0][0]) || !empty($body['components'][0]['example']['header_handle'][0])) {


                $component_header = [];
                $component_body = [];
                $component_buttons = [];
                $templateName = $body['name'];
                if ($body['components'][0]['type'] === 'HEADER' && $body['components'][0]['format'] === 'TEXT') {
                    if (!empty($request->headerParam)) {

                        $component_header = [];

                        $componentHeader = [
                            'type' => 'text',
                            'text' => $request->headerParam,
                        ];
                        $component_header[] = $componentHeader;

                    }
                } elseif ($body['components'][0]['type'] === 'HEADER' && $body['components'][0]['format'] === 'IMAGE') {


                    $componentHeader = [
                        'type' => 'image',
                        'image' => [
                            'link' => $request->headerParam,
                        ],
                    ];
                    $component_header[] = $componentHeader;
                } elseif ($body['components'][0]['type'] === 'HEADER' && $body['components'][0]['format'] === 'DOCUMENT') {
                    $componentHeader = [
                        'type' => 'document',
                        'document' => [
                            'link' => $request->headerParam,
                        ],
                    ];
                    $component_header[] = $componentHeader;
                } else {

                    $component_header = [];
                }
                // Assuming $reply->parameters contains the JSON data


                if ($body['components'][0]['type'] === 'BODY' || $body['components'][1]['type'] === 'BODY') {
                    if (!empty($request->body)) {
                        $bodyString = $request->body;
                        $bodyArray = explode(',', $bodyString);

                        $component_body = [];


                        foreach ($bodyArray as $value) {

                            $componentBody = [
                                'type' => 'text',
                                'text' => $value,
                            ];

                            $component_body[] = $componentBody;
                        }
                    }
                }
                $components = new Component($component_header, $component_body, $component_buttons);
                $response = $whatsapp_app_cloud_api->sendTemplate($contact->phone, $templateName, $language, $components);
                $logs['user_id'] = Auth::id();
                $logs['cloudapi_id'] = $cloudapi->id;
                $logs['from'] = $cloudapi->phone ?? null;
                $logs['to'] = $contact->phone;
                $logs['type'] = 'bulk-message';
                $logs['template_id'] = $template->id ?? null;
                $this->saveLog($logs);
                $this->saveMessageToUserChat($userChat, $template->title, $template->type, $contact->phone, $cloudapi->id);
                return response()->json([
                    'message_status' => 'Success',
                    'data' => [
                        'from' => $cloudapi->phone ?? null,
                        'to' => $contact->phone,
                        'status_code' => 200,
                    ]
                ], 200);
            } else {
                try {
                    $response = $whatsapp_app_cloud_api->sendTemplate($contact->phone, $templateName, $body['language']);
                    $logs['user_id'] = Auth::id();
                    $logs['cloudapi_id'] = $cloudapi->id;
                    $logs['from'] = $cloudapi->phone ?? null;
                    $logs['to'] = $contact->phone;
                    $logs['type'] = 'bulk-message';
                    $logs['template_id'] = $template->id ?? null;
                    $this->saveLog($logs);
                    $this->saveMessageToUserChat($userChat, $template->title, $template->type, $contact->phone, $cloudapi->id);
                    return response()->json([
                        'message_status' => 'Success',
                        'data' => [
                            'from' => $cloudapi->phone ?? null,
                            'to' => $contact->phone,
                            'status_code' => 200,
                        ]
                    ], 200);
                } catch (\Netflie\WhatsAppCloudApi\Response\ResponseException $e) {
                    $errorDetails = $e->getMessage(); // This gets the JSON string
                    $errorObject = json_decode($errorDetails); // Decode into an object

                    // Now, access the nested message property
                    $errorMessage = isset($errorObject->error->message) ? $errorObject->error->message : 'An unknown error occurred';
                    return response()->json([
                        'message' => $errorMessage
                    ], 500);
                }
            }
        }

        return response()->json([
            'message' => __('!Opps Request Failed'),
        ], 401);


    }


    public function templateWithMessage()
    {

        $templates = Template::where('user_id', Auth::id())->where('status', 1)->latest()->get();
        $contacts = Contact::where('user_id', Auth::id())->latest()->get();
        $cloudapis = CloudApi::where('user_id', Auth::id())->where('status', 1)->latest()->get();

        return view('user.template.template', compact('templates', 'contacts', 'cloudapis'));
    }


}
