<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedulemessage;
use Carbon\Carbon;
use App\Models\Schedulecontact;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\CloudApi;
use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Row;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Section;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Action;
use Netflie\WhatsAppCloudApi\Message\Media\LinkID;
use Netflie\WhatsAppCloudApi\Message\Media\MediaObjectID;
use Netflie\WhatsAppCloudApi\Message\Template\Component;
use App\Traits\Cloud;
use App\Traits\Notifications;
class CronController extends Controller
{
    use Cloud;
    use Notifications;
    public $whatsapp_app_cloud_api;


    /**
     * execute shedule
     *
     * @return string
     */
    public function ExecuteSchedule()
    {
        $today = Carbon::now();
        $now = Carbon::parse($today)->tz(env('TIME_ZONE', 'UTC'));

        $schedulemessages = Schedulemessage::whereHas('contacts')->whereHas('cloudapi')->whereHas('user', function ($q) {
            return $q->where('will_expire', '>', now());
        })->with('contacts', 'cloudapi', 'user', 'template')->where('schedule_at', '<=', $now)->where('status', 'pending')->get();



        foreach ($schedulemessages as $key => $schedulemessage) {

            $schedule = Schedulemessage::where('id', $schedulemessage->id)->with('user', 'contacts')->first();

            $response = $this->sentRequest($schedulemessage);
            if ($response == 200) {
                $schedule->status = 'delivered';
            } else {
                $schedule->status = 'rejected';
            }

            $schedule->save();
        }

        return "Cron job executed";
    }



    public function saveMessageToUserChat($userChat, $templateName, $type, $request_from, $templateCloudId)
    {
        if ($userChat) {
            $userChatMessages = json_decode($userChat->message_history, true) ?? [];
            $chatID = uniqid('chat_', true);
            $newMessage = [
                'chatID' => $chatID,
                'message' => 'Scheduled Message-[' . $type . ']:' . $templateName,
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
                    'message' => 'Scheduled Message-[' . $type . ']:' . $templateName,
                    'timestamp' => now()->toDateTimeString(),
                    'type' => 'sent',
                ]
            ]);
            $newUserChat->save();

        }
    }


    /**
     * notify to subscribers before expire the subscription
     */
    public function sentRequest($data)
    {
        $cloudapi = CloudApi::where('id', $data['cloudapi_id'])->latest()->first();
        $whatsapp_app_cloud_api = new WhatsAppCloudApi([
            'from_phone_number_id' => $cloudapi->phone_number_id,
            'access_token' => $cloudapi->access_token,
        ]);
        if (!empty($data->template)) {
            $template = $data->template;

            if (isset($template->body['text'])) {
                $body = $template->body;
                $user = $data->user;

                $reciverContact['name'] = $data->contacts[0]->name;
                $reciverContact['phone'] = $data->contacts[0]->phone;
                $reciverContact['param1'] = $data->contacts[0]->param1;
                $reciverContact['param2'] = $data->contacts[0]->param2;
                $reciverContact['param3'] = $data->contacts[0]->param3;
                $reciverContact['param4'] = $data->contacts[0]->param4;
                $reciverContact['param5'] = $data->contacts[0]->param5;
                $reciverContact['param6'] = $data->contacts[0]->param6;
                $reciverContact['param7'] = $data->contacts[0]->param7;

                $text = $this->formatText($template->body['text'], $reciverContact, $user);
                $body['text'] = $text;
            } else {

                $body = $template->body;

            }

            $type = $template->type;
            $logs['template_id'] = $data->template_id;
        } else {
            $user = $data->user;
            $reciverContact['name'] = $data->contacts[0]->name;
            $reciverContact['phone'] = $data->contacts[0]->phone;
            $reciverContact['param1'] = $data->contacts[0]->param1;
            $reciverContact['param2'] = $data->contacts[0]->param2;
            $reciverContact['param3'] = $data->contacts[0]->param3;
            $reciverContact['param4'] = $data->contacts[0]->param4;
            $reciverContact['param5'] = $data->contacts[0]->param5;
            $reciverContact['param6'] = $data->contacts[0]->param6;
            $reciverContact['param7'] = $data->contacts[0]->param7;

            $text = $this->formatText($data->body, $reciverContact, $user);
            $body = array('text' => $text);
            $type = 'plain-text';

        }



        $cloudapi_id = $data->cloudapi_id;
        $from = $data->cloudapi->phone;
        $status = null;

        foreach ($data->contacts as $key => $contact) {
            $userChat = ChatMessage::where('phone_number', $contact->phone)->where('cloudapi_id', $cloudapi_id)->first();
            try {

                if ($type == 'plain-text') {
                    $body['text'] = $text;
                    $message = $this->formatText($data->body, $contact, $user);
                    $resonse = $whatsapp_app_cloud_api->sendTextMessage($contact->phone, $message, true);
                    $this->saveMessageToUserChat($userChat, $message, $type, $contact->phone, $cloudapi_id);

                } elseif ($type == 'text-with-image') {
                    $link_id = new LinkID($body['image']['url']);
                    $resonse = $whatsapp_app_cloud_api->sendImage($contact->phone, $link_id, $body['caption']);
                    $this->saveMessageToUserChat($userChat, $body['caption'], $type, $contact->phone, $cloudapi_id);
                } elseif ($type == 'text-with-list') {
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
                    $resonse = $whatsapp_app_cloud_api->sendList(
                        $contact->phone,
                        $data['title'],
                        $data['text'],
                        $data['footer'],
                        $action
                    );

                    $this->saveMessageToUserChat($userChat, $data['title'], $type, $contact->phone, $cloudapi_id);

                } elseif ($type == 'text-with-media') {
                    $data = $body;

                    if (isset($data['image']) && !empty($data['image']['url'])) {
                        $link_id = new LinkID($data['image']['url']);
                        $response = $whatsapp_app_cloud_api->sendImage($contact->phone, $link_id);
                        $this->saveMessageToUserChat($userChat, $template->title, $type, $contact->phone, $cloudapi_id);
                    } elseif (isset($data['document']) && !empty($data['document']['url'])) {
                        $document_caption = $data['caption'];
                        $document_url = $data['document']['url'];
                        $document_name = basename($document_url);
                        $link_id = new LinkID($document_url);
                        $response = $whatsapp_app_cloud_api->sendDocument($contact->phone, $link_id, $document_name, $document_caption);
                        $this->saveMessageToUserChat($userChat, $template->title, $type, $contact->phone, $cloudapi_id);
                    }


                } elseif ($type == 'text-with-location') {
                    $data = $body;
                    $latitude = $data['location']['degreesLatitude'];
                    $longitude = $data['location']['degreesLongitude'];
                    $response = $whatsapp_app_cloud_api->sendLocation($contact->phone, (float) $latitude, (float) $longitude, '');
                    $this->saveMessageToUserChat($userChat, $template->title, $type, $contact->phone, $cloudapi_id);
                } elseif ($type == 'meta-template') {
                    $templateName = $body['name'];
                    if (!empty($body['components'][0]['example']['header_text'][0]) || !empty($body['components'][0]['example']['body_text'][0][0]) || !empty($body['components'][0]['example']['header_handle'][0])) {

                        $component_header = [];
                        $component_body = [];
                        $component_buttons = [];
                        $templateName = $body['name'];
                        $parameters = $data['body'];
                        $parametersData = json_decode($parameters, true);
                        if ($body['components'][0]['type'] === 'HEADER' && $body['components'][0]['format'] === 'TEXT') {
                            if (!empty($parametersData['header_parameters'])) {
                                $message = $this->formatText($parametersData['header_parameters'], $contact, $data->user);

                                $component_header = [];

                                $componentHeader = [
                                    'type' => 'text',
                                    'text' => $message,
                                ];
                                $component_header[] = $componentHeader;

                            }
                        } elseif ($body['components'][0]['type'] === 'HEADER' && $body['components'][0]['format'] === 'IMAGE') {


                            $componentHeader = [
                                'type' => 'image',
                                'image' => [
                                    'link' => $parametersData['header_parameters'],
                                ],
                            ];
                            $component_header[] = $componentHeader;
                        } elseif ($body['components'][0]['type'] === 'HEADER' && $body['components'][0]['format'] === 'DOCUMENT') {
                            $componentHeader = [
                                'type' => 'document',
                                'document' => [
                                    'link' => $parametersData['header_parameters'],
                                ],
                            ];
                            $component_header[] = $componentHeader;
                        } else {

                            $component_header = [];
                        }

                        if ($body['components'][0]['type'] === 'BODY' || $body['components'][1]['type'] === 'BODY') {
                            if (!empty($parametersData['message_parameters'])) {

                                $component_body = [];

                                foreach ($parametersData['message_parameters'] as $value) {
                                    $context = $this->formatText($value, $contact, $data->user);
                                    $componentBody = [
                                        'type' => 'text',
                                        'text' => $context,
                                    ];

                                    $component_body[] = $componentBody;
                                }
                            }
                        }

                        $components = new Component($component_header, $component_body, $component_buttons);
                        $response = $whatsapp_app_cloud_api->sendTemplate($contact->phone, $templateName, $body['language'], $components);
                        $this->saveMessageToUserChat($userChat, $templateName, $type, $contact->phone, $cloudapi_id);
                    } else {
                        $whatsapp_app_cloud_api->sendTemplate($contact->phone, $templateName, $body['language']);
                        $this->saveMessageToUserChat($userChat, $templateName, $type, $contact->phone, $cloudapi_id);
                    }
                }

                $status = 200;
            } catch (\Exception $e) {
                $status = 500;
            }
        }

        return $status;
    }


    /**
     * notify to subscribers before expire the subscription
     *
     * @return string
     */
    public function notifyToUser()
    {
        $willExpire = today()->addDays(7)->format('Y-m-d');
        $users = User::whereHas('subscription')->with('subscription')->where('will_expire', $willExpire)->latest()->get();

        foreach ($users as $key => $user) {
            $this->sentWillExpireEmail($user);
        }

        return "Cron job executed";
    }

    /**
     * remove junk cloudapis
     *
     * @return string
     */
    public function removeJunkCloudApi()
    {
        $subdays = today()->subDays(7);
        $cloudapis = CloudApi::where('acess_token', null)->where('created_at', $subdays)->delete();

        return "Cron job executed";
    }

}
