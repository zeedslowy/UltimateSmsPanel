<?php

namespace App\Jobs;

use Aloha\Twilio\Twilio;
use App\Classes\SmsGateway;
use App\Client;
use App\SMSHistory;
use App\SMSInbox;
use Aws\Sns\Exception\SnsException;
use Aws\Sns\SnsClient;
use Elibom\APIClient\ElibomClient;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Artisan;
use Nexmo\Client\Credentials\Basic;
use Nexmo\Client\Exception\Exception;
use Osms\Osms;
use Plivo\RestAPI;
use telesign\sdk\messaging\MessagingClient;

class SendBulkSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $cl_phone;
    protected $user_id;
    protected $gateway;
    protected $sender_id;
    protected $message;
    protected $msgcount;
    protected $cg_info;
    protected $api_key;
    protected $get_sms_status;
    protected $msg_type;
    public $tries = 2;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $cl_phone, $gateway, $sender_id, $message, $msgcount, $cg_info = '', $api_key = '', $msg_type = 'plain')
    {
        $this->cl_phone = $cl_phone;
        $this->gateway = $gateway;
        $this->sender_id = $sender_id;
        $this->message = $message;
        $this->msgcount = $msgcount;
        $this->cg_info = $cg_info;
        $this->api_key = $api_key;
        $this->user_id = $user_id;
        $this->msg_type = $msg_type;

    }

    private function make_stop_dup_id()
    {
        return 0;
    }

    private function make_post_body($post_fields)
    {
        $stop_dup_id = $this->make_stop_dup_id();
        if ($stop_dup_id > 0) {
            $post_fields['stop_dup_id'] = $this->make_stop_dup_id();
        }
        $post_body = '';
        foreach ($post_fields as $key => $value) {
            $post_body .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $post_body = rtrim($post_body, '&');

        return $post_body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $gateway_url = rtrim($this->gateway->api_link, '/');
        $gateway_name = $this->gateway->name;
        $gateway_user_name = $this->gateway->username;
        $gateway_password = $this->gateway->password;
        $gateway_extra = $this->gateway->api_id;
        $msg_type = $this->msg_type;

        $client_ip = request()->ip();

        if ($this->gateway->custom == 'Yes' && $this->cg_info != '') {

            $send_custom_data = array();
            $username_param = $this->cg_info->username_param;
            $username_value = $this->cg_info->username_value;

            $send_custom_data[$username_param] = $username_value;

            if ($this->cg_info->password_status == 'yes') {
                $password_param = $this->cg_info->password_param;
                $password_value = $this->cg_info->password_value;

                $send_custom_data[$password_param] = $password_value;
            }

            if ($this->cg_info->action_status == 'yes') {
                $action_param = $this->cg_info->action_param;
                $action_value = $this->cg_info->action_value;

                $send_custom_data[$action_param] = $action_value;
            }

            if ($this->cg_info->source_status == 'yes') {
                $source_param = $this->cg_info->source_param;
                $source_value = $this->cg_info->source_value;

                $send_custom_data[$source_param] = $source_value;
            }

            $destination_param = $this->cg_info->destination_param;
            $send_custom_data[$destination_param] = $this->cl_phone;

            $message_param = $this->cg_info->message_param;
            $send_custom_data[$message_param] = $this->message;

            if ($this->cg_info->route_status == 'yes') {
                $route_param = $this->cg_info->route_param;
                $route_value = $this->cg_info->route_value;

                $send_custom_data[$route_param] = $route_value;
            }

            if ($this->cg_info->language_status == 'yes') {
                $language_param = $this->cg_info->language_param;
                $language_value = $this->cg_info->language_value;

                $send_custom_data[$language_param] = $language_value;
            }

            if ($this->cg_info->custom_one_status == 'yes') {
                $custom_one_param = $this->cg_info->custom_one_param;
                $custom_one_value = $this->cg_info->custom_one_value;

                $send_custom_data[$custom_one_param] = $custom_one_value;
            }

            if ($this->cg_info->custom_two_status == 'yes') {
                $custom_two_param = $this->cg_info->custom_two_param;
                $custom_two_value = $this->cg_info->custom_two_value;

                $send_custom_data[$custom_two_param] = $custom_two_value;
            }

            if ($this->cg_info->custom_three_status == 'yes') {
                $custom_three_param = $this->cg_info->custom_three_param;
                $custom_three_value = $this->cg_info->custom_three_value;

                $send_custom_data[$custom_three_param] = $custom_three_value;
            }

            $get_post_data = $this->make_post_body($send_custom_data);

            try {
                $sms_sent_to_user = $gateway_url . "?" . $get_post_data;

                $ch = curl_init($sms_sent_to_user);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                curl_close($ch);

                if (preg_match('(delivery|success|ok|message_pending|accept)', $output) === 1) {
                    $get_sms_status = 'Success';
                } else {
                    $get_sms_status = trim($output);
                }

            } catch (\Exception $e) {
                $get_sms_status = $e->getMessage();
            }
        } else {
            switch ($gateway_name) {
                case 'Twilio':

                    try {
                        $twilio = new Twilio($gateway_user_name, $gateway_password, $this->sender_id);
                        $get_response = $twilio->message($this->cl_phone, $this->message);

                        $get_sms_status = 'Success|' . $get_response->sid;
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }
                    break;

                case 'Clickatell':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"content\": \"$this->message\", \"to\": [\"$clphone\"]}");
                    curl_setopt($ch, CURLOPT_POST, 1);

                    $headers = array();
                    $headers[] = "Content-Type: application/json";
                    $headers[] = "Accept: application/json";
                    $headers[] = "Authorization: $gateway_user_name";
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $response = curl_exec($ch);

                    if (curl_errno($ch)) {
                        $get_sms_status = curl_error($ch);
                    }
                    curl_close($ch);


                    $get_result = json_decode($response, true);

                    if (is_array($get_result)) {
                        if ($get_result['error'] == '') {
                            $get_sms_status = 'Success|' . $get_result['messages']['0']['apiMessageId'];
                        } else {
                            $get_sms_status = $get_result['error'];
                        }
                    } else {
                        $get_sms_status = 'Unknown error';
                    }

                    break;

                case 'SMSKaufen':

                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);

                    $sms_sent_to_user = $gateway_url . "?type=4" . "&id=$gateway_user_name" . "&apikey=$gateway_password" . "&empfaenger=$this->cl_phone" . "&absender=$sender_id" . "&text=$message";

                    $get_sms_status = file_get_contents($sms_sent_to_user);

                    $get_sms_status = str_replace("100", "Success", $get_sms_status);
                    $get_sms_status = str_replace("101", "Success", $get_sms_status);
                    $get_sms_status = str_replace("111", "What IP blocked", $get_sms_status);
                    $get_sms_status = str_replace("112", "Incorrect login data", $get_sms_status);
                    $get_sms_status = str_replace("120", "Sender field is empty", $get_sms_status);
                    $get_sms_status = str_replace("121", "Gateway field is empty", $get_sms_status);
                    $get_sms_status = str_replace("122", "Text is empty", $get_sms_status);
                    $get_sms_status = str_replace("123", "Recipient field is empty", $get_sms_status);
                    $get_sms_status = str_replace("129", "Wrong sender", $get_sms_status);
                    $get_sms_status = str_replace("130", "Gateway Error", $get_sms_status);
                    $get_sms_status = str_replace("131", "Wrong number", $get_sms_status);
                    $get_sms_status = str_replace("132", "Mobile phone is off", $get_sms_status);
                    $get_sms_status = str_replace("133", "Query not possible", $get_sms_status);
                    $get_sms_status = str_replace("134", "Number invalid", $get_sms_status);
                    $get_sms_status = str_replace("140", "No credit", $get_sms_status);
                    $get_sms_status = str_replace("150", "SMS blocked", $get_sms_status);
                    $get_sms_status = str_replace("170", "Date wrong", $get_sms_status);
                    $get_sms_status = str_replace("171", "Date too old", $get_sms_status);
                    $get_sms_status = str_replace("172", "Too many numbers", $get_sms_status);
                    $get_sms_status = str_replace("173", "Format wrong", $get_sms_status);
                    $get_sms_status = str_replace(",", " ", $get_sms_status);
                    break;

                case 'Route SMS':

                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    $sms_url = rtrim($gateway_url, '/');

                    try {

                        if ($msg_type == 'unicode') {
                            $type = 2;
                        } else {
                            $type = 0;
                        }

                        $sms_sent_to_user = "$sms_url" . "/bulksms/bulksms?type=$type" . "&username=$gateway_user_name" . "&password=$gateway_password" . "&destination=$this->cl_phone" . "&source=$sender_id" . "&message=$message" . "&dlr=0";

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $headers = array();
                        $headers[] = "Content-Type: application/x-www-form-urlencoded";
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


                        $get_sms_status = curl_exec($ch);
                        curl_close($ch);

//                        $get_sms_status = file_get_contents($sms_sent_to_user);
                        $get_sms_status = str_replace("1701", "Success", $get_sms_status);
                        $get_sms_status = str_replace("1702", "Invalid URL", $get_sms_status);
                        $get_sms_status = str_replace("1703", "Invalid User or Password", $get_sms_status);
                        $get_sms_status = str_replace("1704", "Invalid Type", $get_sms_status);
                        $get_sms_status = str_replace("1705", "Invalid SMS", $get_sms_status);
                        $get_sms_status = str_replace("1706", "Invalid receiver", $get_sms_status);
                        $get_sms_status = str_replace("1707", "Invalid sender", $get_sms_status);
                        $get_sms_status = str_replace("1709", "User Validation Failed", $get_sms_status);
                        $get_sms_status = str_replace("1710", "Internal Error", $get_sms_status);
                        $get_sms_status = str_replace("1715", "Response Timeout", $get_sms_status);
                        $get_sms_status = str_replace("1025", "Insufficient Credit", $get_sms_status);
                        $get_sms_status = str_replace(",", " ", $get_sms_status);

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;


                case 'SMSGlobal':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);

                    $sms_sent_to_user = $gateway_url . "?action=sendsms" . "&user=$gateway_user_name" . "&password=$gateway_password" . "&from=$sender_id" . "&to=$clphone" . "&text=$message" . "&api=1";

                    $get_sms_status = file_get_contents($sms_sent_to_user);
                    $get_sms_status = preg_replace("/[^0-9]/", '', $get_sms_status);

                    $get_sms_status = str_replace("88", "Not enough credits", $get_sms_status);
                    $get_sms_status = str_replace("99", "Unknown error", $get_sms_status);
                    $get_sms_status = str_replace("100", "Incorrect username/password", $get_sms_status);
                    $get_sms_status = str_replace("300", "Missing MSISDN", $get_sms_status);
                    $get_sms_status = str_replace("750", "Invalid MSISDN", $get_sms_status);

                    break;

                case 'Nexmo':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    try {

                        $client = new \Nexmo\Client(new Basic($gateway_user_name, $gateway_password));

                        if ($msg_type == 'unicode') {
                            $type = 'unicode';
                        } else {
                            $type = 'text';
                        }

                        $sms_data = [
                            'to' => $clphone,
                            'from' => $this->sender_id,
                            $type => $this->message
                        ];

                        $response = $client->message()->send($sms_data);

                        if ($response['status'] == 0) {
                            $get_sms_status = 'Success';
                        } else {
                            $get_sms_status = 'Unknown Error';
                        }

                    } catch (Exception $exception) {
                        $get_sms_status = $exception->getMessage();
                    }

                    break;

                case 'Kapow':

                    $posturl = $gateway_url . "?username=$gateway_user_name" . "&password=$gateway_password" . "&mobile=$this->cl_phone" . "&sms=$this->message";

                    if ($this - $this->sender_id != '') {
                        $posturl .= '&from_id=' . urlencode($this->sender_id);
                    }

                    $handle = fopen($posturl, 'r');
                    if ($handle) {
                        $response = stream_get_contents($handle);

                        if (strstr($response, 'OK')) {
                            $get_sms_status = "Success";
                        }
                        if ($response == 'USERPASS') {
                            $get_sms_status = "Your credentials are incorrect";
                        }

                        if ($response == 'ERROR') {
                            $get_sms_status = "Error";
                        }
                        if ($response == 'NOCREDIT') {
                            $get_sms_status = "You have no credits remaining";
                        }
                    } else {
                        $get_sms_status = 'Unable to open URL';
                    }

                    break;

                case 'Zang':

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://api.zang.io/v2/Accounts/{$gateway_user_name}/SMS/Messages.json");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "To=$this->cl_phone&From=$this->sender_id&Body=$this->message");
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_USERPWD, "{$gateway_user_name}" . ":" . "{$gateway_password}");

                    $headers = array();
                    $headers[] = "Content-Type: application/x-www-form-urlencoded";
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        $get_sms_status = curl_error($ch);
                    }
                    curl_close($ch);

                    $decoded_response = json_decode($result, true);
                    if (array_key_exists('message', $decoded_response)) {
                        $get_sms_status = $decoded_response['message'];
                    } elseif (array_key_exists('sid', $decoded_response)) {
                        $get_sms_status = 'Success|' . $decoded_response['sid'];
                    } else {
                        $get_sms_status = 'Api info not correct';
                    }

                    break;

                case 'InfoBip':

                    $message_id = _raid(19);

                    // creating an object for sending SMS
                    $destination = array("messageId" => $message_id, "to" => $this->cl_phone);
                    $message = array(
                        "from" => $this->sender_id,
                        "destinations" => array($destination),
                        "text" => $this->message
                    );
                    $postData = array("messages" => array($message));
                    // encoding object
                    $postDataJson = json_encode($postData);


                    $ch = curl_init();
                    $header = array("Content-Type:application/json", "Accept:application/json");

                    // setting options
                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_USERPWD, $gateway_user_name . ":" . $gateway_password);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                    curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postDataJson);

                    // response of the POST request
                    $response = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $get_data = json_decode($response, true);
                    curl_close($ch);

                    if (is_array($get_data)) {
                        if (array_key_exists('messages', $get_data)) {
                            foreach ($get_data['messages'] as $msg) {
                                if ($msg['status']['name'] == 'MESSAGE_ACCEPTED' || $msg['status']['name'] == 'PENDING_ENROUTE') {
                                    $get_sms_status = 'Success|' . $msg['messageId'];
                                } else {
                                    $get_sms_status = $msg['status']['description'];
                                }
                            }
                        } elseif (array_key_exists('requestError', $get_data)) {
                            foreach ($get_data['requestError'] as $msg) {
                                $get_sms_status = $msg['text'];
                            }
                        } else {
                            $get_sms_status = 'Unknown error';
                        }
                    } else {
                        $get_sms_status = 'Unknown error';
                    }

                    break;

                case 'RANNH':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);

                    $sms_sent_to_user = $gateway_url . "?user=$gateway_user_name" . "&password=$gateway_password" . "&numbers=$clphone" . "&sender=$sender_id" . "&message=" . urlencode($this->message) . "&lang=en";

                    $get_sms_status = file_get_contents($sms_sent_to_user);

                    if ($get_sms_status == '1') {
                        $get_sms_status = 'Success';
                    } elseif ($get_sms_status == '0') {
                        $get_sms_status = 'Transmission error';
                    } else {
                    }

                    break;

                case 'Bulk SMS':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);


                    $url = $gateway_url . "/submission/send_sms/2/2.0?username=$gateway_user_name" . "&password=$gateway_password" . "&msisdn=$clphone" . "&message=" . urlencode($this->message) . "&repliable=1";
                    if ($msg_type == 'unicode') {
                        $url .= "&dca=16bit";
                    }

                    if ($sender_id != '') {
                        $url .= "&sender=$sender_id";
                    }

                    $ret = file_get_contents($url);

                    $send = explode("|", $ret);

                    if ($send[0] == '0') {
                        $get_sms_status = 'In progress|' . $send['2'];
                    } elseif ($send[0] == '1') {
                        $get_sms_status = 'Scheduled ';
                    } elseif ($send[0] == '22') {
                        $get_sms_status = 'Internal fatal error ';
                    } elseif ($send[0] == '23') {
                        $get_sms_status = 'Authentication failure';
                    } elseif ($send[0] == '24') {
                        $get_sms_status = 'Data validation failed';
                    } elseif ($send[0] == '25') {
                        $get_sms_status = 'You do not have sufficient credits';
                    } elseif ($send[0] == '26') {
                        $get_sms_status = 'Upstream credits not available';
                    } elseif ($send[0] == '27') {
                        $get_sms_status = 'You have exceeded your daily quota';
                    } elseif ($send[0] == '28') {
                        $get_sms_status = 'Upstream quota exceeded';
                    } elseif ($send[0] == '40') {
                        $get_sms_status = 'Temporarily unavailable';
                    } elseif ($send[0] == '201') {
                        $get_sms_status = 'Maximum batch size exceeded';
                    } elseif ($send[0] == '200') {
                        $get_sms_status = 'Success';
                    } else {
                        $get_sms_status = 'Failed';
                    }


                    break;

                /*Verson 1.1*/

                case 'Plivo':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);

                    $plivo = new RestAPI($gateway_user_name, $gateway_password);
                    $params = array(
                        'src' => $sender_id,
                        'dst' => $clphone,
                        'text' => $this->message
                    );

                    $response = $plivo->send_message($params);

                    if (array_key_exists('status', $response)) {
                        if ($response['status'] == 202) {
                            $get_sms_status = 'Success|' . $response['response']['message_uuid'][0];
                        } elseif ($response['status'] == '400') {
                            $get_sms_status = $response['response']['error'];
                        } else {
                            if (array_key_exists('error', $response['response'])) {
                                $get_sms_status = $response['response']['error'];
                            } else {
                                $get_sms_status = 'Failed';
                            }
                        }
                    } else {
                        $get_sms_status = 'Failed';
                    }

                    break;

                case 'SMSIndiaHub':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $message = urlencode($this->message);

                    $ch = curl_init("$gateway_url?user=" . $gateway_user_name . "&password=" . $gateway_password . "&msisdn=" . $clphone . "&sid=" . $this->sender_id . "&msg=" . $message . "&fl=0");
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);

                    $response = json_decode($output);
                    $get_sms_status = $response->ErrorMessage;

                    break;

                case 'Text Local':

                    $sender = urlencode($this->sender_id);
                    $message = rawurlencode($this->message);

                    $data = array('username' => $gateway_user_name, 'hash' => $gateway_password, 'numbers' => $this->cl_phone, "sender" => $sender, "message" => $message, "unicode" => true);

                    // Send the POST request with cURL
                    $ch = curl_init($gateway_url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    $get_data = json_decode($response, true);

                    if (array_key_exists('status', $get_data)) {
                        if ($get_data['status'] == 'failure') {
                            foreach ($get_data['errors'] as $err) {
                                $get_sms_status = $err['message'];
                            }
                        } else {
                            $get_sms_status = 'Success';
                        }

                    } else {
                        $get_sms_status = 'failed';
                    }

                    break;

                case 'Top10sms':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);

                    $sms_sent_to_user = $gateway_url . "?action=compose" . "&username=$gateway_user_name" . "&api_key=$gateway_password" . "&to=$clphone" . "&sender=$sender_id" . "&message=" . urlencode($this->message) . "&unicode=1";

                    $get_sms_status = file_get_contents($sms_sent_to_user);
                    $get_sms_status = trim(substr($get_sms_status, 0, strpos($get_sms_status, ":")));


                    break;

                case 'msg91':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);


                    //Define route
                    $route = "default";

                    //Prepare you post parameters
                    $postData = array(
                        'authkey' => $gateway_password,
                        'mobiles' => $clphone,
                        'message' => $message,
                        'sender' => $sender_id,
                        'route' => $route,
                        'response' => 'json',
                    );

                    if ($msg_type == 'unicode') {
                        $postData['unicode'] = 1;
                    }

                    // init the resource
                    $ch = curl_init();
                    curl_setopt_array($ch, array(
                        CURLOPT_URL => $gateway_url,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $postData
                    ));


                    //Ignore SSL certificate verification
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                    //get response
                    $output = curl_exec($ch);

                    //Print error if any
                    if (curl_errno($ch)) {
                        $get_sms_status = curl_error($ch);
                    }

                    curl_close($ch);
                    $get_data = json_decode($output, true);
                    if (array_key_exists('message', $get_data)) {
                        $get_sms_status = $get_data['message'];
                    } else {
                        $get_sms_status = 'failed';
                    }

                    break;

                case 'ShreeWeb':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);

                    $ch = curl_init("$gateway_url?username=" . $gateway_user_name . "&password=" . $gateway_password . "&mobile=" . $clphone . "&sender=" . $sender_id . "&message=" . $message . "&type=TEXT");
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $output = curl_exec($ch);
                    curl_close($ch);

                    $output = trim($output);

                    if ($output != '') {
                        if (strpos($output, 'SUBMIT_SUCCESS') !== false) {
                            $get_sms_status = 'Success';
                        } elseif ($output == 'ERR_PARAMETER') {
                            $get_sms_status = 'Invalid  parameter';
                        } elseif ($output == 'ERR_MOBILE') {
                            $get_sms_status = 'Invalid  Phone Number';
                        } elseif ($output == 'ERR_SENDER') {
                            $get_sms_status = 'Invalid  Sender';
                        } elseif ($output == 'ERR_MESSAGE_TYPE') {
                            $get_sms_status = 'Invalid  Message Type';
                        } elseif ($output == 'ERR_MESSAGE') {
                            $get_sms_status = 'Invalid  Message';
                        } elseif ($output == 'ERR_SPAM') {
                            $get_sms_status = 'Spam  Message';
                        } elseif ($output == 'ERR_DLR') {
                            $get_sms_status = 'Dlr requisition is invalid.';
                        } elseif ($output == 'ERR_USERNAME') {
                            $get_sms_status = 'Invalid Username';
                        } elseif ($output == 'ERR_PASSWORD') {
                            $get_sms_status = 'Invalid Password';
                        } elseif ($output == 'ERR_LOGIN') {
                            $get_sms_status = 'Invalid Login Access';
                        } elseif ($output == 'ERR_CREDIT') {
                            $get_sms_status = 'Insufficient Balance';
                        } elseif ($output == 'ERR_DATETIME') {
                            $get_sms_status = 'Invalid Time format';
                        } elseif ($output == 'ERR_GMT') {
                            $get_sms_status = 'Invalid GMT';
                        } elseif ($output == 'ERR_ROUTING') {
                            $get_sms_status = 'Invalid Routing';
                        } elseif ($output == 'ERR_INTERNAL') {
                            $get_sms_status = 'Server Down For Maintenance';
                        } else {
                            $get_sms_status = 'Unknown Error';
                        }
                    } else {
                        $get_sms_status = 'Unknown Error';
                    }

                    break;

                case 'SmsGatewayMe':

                    include_once app_path('Classes/smsGateway.php');

                    $sms_info = new SmsGateway($gateway_user_name, $gateway_password);
                    $response = $sms_info->sendMessageToNumber($this->cl_phone, $this->message, $gateway_extra);


                    $get_sms_status = '';
                    if (is_array($response)) {
                        if (array_key_exists('response', $response)) {
                            if ($response['response']['success']) {
                                $get_sms_status = 'Success';
                            } else {
                                foreach ($response['response']['errors'] as $key => $value) {
                                    $get_sms_status .= ' ' . $value;
                                }
                            }
                        }
                    } else {
                        $get_sms_status = 'Unknown Error';
                    }

                    $get_sms_status = trim($get_sms_status);

                    break;

                case 'Elibom':
                    require_once(app_path('libraray/elibom/src/elibom_client.php'));
                    $elbom = new ElibomClient($gateway_user_name, $gateway_password);
                    try {
                        $get_sms_status = 'Success|' . $elbom->sendMessage($this->cl_phone, $this->message);
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }
                    break;


                case 'Hablame':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $data = array(
                        'cliente' => $gateway_user_name, //Numero de cliente
                        'api' => $gateway_password, //Clave API suministrada
                        'numero' => $clphone, //numero o numeros telefonicos a enviar el SMS (separados por una coma ,)
                        'sms' => $this->message, //Mensaje de texto a enviar
                    );

                    $options = array(
                        'http' => array(
                            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                            'method' => 'POST',
                            'content' => http_build_query($data)
                        )
                    );
                    $context = stream_context_create($options);
                    $result = json_decode((file_get_contents($gateway_url, false, $context)), true);

                    if (is_array($result) && array_key_exists('resultado', $result)) {
                        if ($result["resultado"] === 0) {
                            $get_sms_status = 'Success';
                        } else {
                            $get_sms_status = $result['resultado_t'];
                        }
                    } else {
                        $get_sms_status = 'ha ocurrido un error';
                    }

                    break;

                case 'Wavecell':

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, "https://api.wavecell.com/sms/v1/$gateway_user_name/single");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"source\":\"$this->sender_id\", \"destination\":\"$this->cl_phone\", \"text\":\"$this->message\", \"encoding\":\"AUTO\" }");
                    curl_setopt($ch, CURLOPT_POST, 1);

                    $headers = array();
                    $headers[] = "Authorization: Bearer $gateway_password";
                    $headers[] = "Content-Type: application/json";
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    }
                    curl_close($ch);
                    $get_data = json_decode($result, true);

                    if (is_array($get_data) && array_key_exists('umid', $get_data)) {
                        $get_sms_status = 'Success|' . $get_data['umid'];
                    } else {
                        $get_sms_status = 'Failed';
                    }


                    break;

                case 'SIPTraffic':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = $this->sender_id;

                    $sms_sent_to_user = $gateway_url . "/myaccount/sendsms.php?username=$gateway_user_name" . "&password=$gateway_password" . "&to=$clphone" . "&from=$sender_id" . "&text=" . urlencode($this->message);

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                    curl_setopt($ch, CURLOPT_HTTPGET, 1);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $get_sms_status = curl_exec($ch);
                    curl_close($ch);

                    $xml = simplexml_load_string($get_sms_status, "SimpleXMLElement", LIBXML_NOCDATA);
                    $json = json_encode($xml);
                    $array = json_decode($json, TRUE);

                    if (is_array($array) && array_key_exists('resultstring', $array)) {
                        $get_sms_status = $array['resultstring'];
                    } else {
                        $get_sms_status = 'Unknown error';
                    }


                    break;

                case 'SMSMKT':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $message = urlencode($this->message);


                    $Parameter = "User=$gateway_user_name&Password=$gateway_password&Msnlist=$clphone&Msg=$message&Sender=$this->sender_id";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $Parameter);

                    $response = curl_exec($ch);
                    curl_close($ch);

                    $response = explode(',', $response);
                    $status = explode('=', $response[0])[1];

                    if ($status == '0') {
                        $get_sms_status = 'Success';
                    } else {

                        $details = explode('=', $response['1']);
                        $get_sms_status = $details['1'];
                    }
                    break;


                case 'MLat':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    // mensajes a enviar
                    $texts = array($this->message);

                    // números correspondientes pilas formato regexp ^04(12|16|26|14|24)\d{7}$
                    $recipients = array($clphone);

                    try {

                        $mlat = new \SoapClient($gateway_url . '?wsdl',
                            array('location' => 'https://m-lat.net/axis2/services/SMSServiceWS?wsdl'));
                        $credential = array('user' => $gateway_user_name, 'password' => $gateway_password);
                        $get_sms_status = $mlat->sendManyTextSMS(array('credential' => $credential, 'text' => $texts, 'recipients' => $recipients));
                    } catch (\Exception $ex) {
                        $get_sms_status = $ex->getMessage();
                    }
                    break;

                case 'NRSGateway':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = $this->sender_id;
                    $message = urlencode($this->message);
                    $gateway_password = urlencode($gateway_password);

                    $sms_sent_to_user = $gateway_url . "?username=$gateway_user_name" . "&password=$gateway_password" . "&to=$clphone" . "&from=$sender_id" . "&text=" . urlencode($this->message) . "&coding=0&dlr-mask=8";

                    $response = file_get_contents($sms_sent_to_user);
                    $result = explode(':', trim($response));

                    if (is_array($result)) {
                        if (array_key_exists('1', $result) && $result['0'] == '0') {
                            $get_sms_status = 'Success';
                        } else {
                            $get_sms_status = trim($result['1']);
                        }
                    } else {
                        $get_sms_status = 'Unknown error';
                    }

                    break;

                case 'Asterisk':
                    Artisan::call('ami:dongle:sms', [
                        'number' => $this->cl_phone,
                        'message' => $this->message,
                        'device' => env('SC_DEVICE'),
                    ]);

                    $get_sms_status = Artisan::output();

                    if (strpos($get_sms_status, 'queued') !== false) {
                        $get_sms_status = 'Success';
                    }

                    break;

                case 'Orange':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $sender_id = str_replace(" ", "", $this->sender_id); #Remove any whitespace
                    $sender_id = str_replace('+', '', $sender_id);

                    $config = array(
                        'clientId' => $gateway_user_name,
                        'clientSecret' => $gateway_password
                    );

                    $osms = new Osms($config);
                    $osms->setVerifyPeerSSL(false);
                    $response = $osms->getTokenFromConsumerKey();


                    if (!empty($response['access_token'])) {
                        $senderAddress = 'tel:+' . $sender_id;
                        $receiverAddress = 'tel:+' . $clphone;
                        $message = $this->message;

                        $get_data = $osms->sendSMS($senderAddress, $receiverAddress, $message);

                        if (empty($get_data['error'])) {
                            $get_sms_status = 'Success';
                        } else {
                            $get_sms_status = $get_data['error'];
                        }

                    } else {
                        $get_sms_status = $response['error'];
                    }

                    break;

                case 'GlobexCam':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = $this->sender_id;
                    $gateway_password = urlencode($gateway_password);

                    $sms_sent_to_user = $gateway_url . "?user=$gateway_user_name" . "&password=$gateway_password" . "&APIKey=$gateway_extra" . "&number=$clphone" . "&senderid=$sender_id" . "&text=" . urlencode($this->message) . "&channel=Normal&DCS=0&flashsms=0";

                    $response = file_get_contents($sms_sent_to_user);
                    $response = json_decode($response, true);

                    if (is_array($response) && array_key_exists('ErrorMessage', $response)) {
                        if ($response['ErrorMessage'] == 'Done') {
                            $get_sms_status = 'Success';
                        } else {
                            $get_sms_status = $response['ErrorMessage'];
                        }
                    } else {
                        $get_sms_status = 'Unknown error';
                    }

                    break;

                case 'Camoo':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = $this->sender_id;

                    $sms_sent_to_user = $gateway_url . "?api_key=$gateway_user_name" . "&api_secret=$gateway_password" . "&to=$clphone" . "&from=$sender_id" . "&message=" . urlencode($this->message);

                    $response = file_get_contents($sms_sent_to_user);
                    $response = json_decode($response, true);

                    if (is_array($response) && array_key_exists('_message', $response)) {
                        if ($response['_message'] == 'succes') {
                            $get_sms_status = 'Success';
                        } else {
                            $get_sms_status = $response['_message'];
                        }
                    } else {
                        $get_sms_status = 'Unknown error';
                    }
                    break;

                case 'Kannel':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = $this->sender_id;

                    try {
                        $sms_sent_to_user = $gateway_url . "?username=$gateway_user_name" . "&password=$gateway_password" . "&to=$clphone" . "&from=$sender_id" . "&text=" . urlencode($this->message);

                        $response = file_get_contents($sms_sent_to_user);

                        if (strpos($response, 'delivery') !== false) {
                            $get_sms_status = 'Success';
                        } else {
                            $get_sms_status = 'Unknown error';
                        }
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'Semysms':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = $this->sender_id;

                    try {
                        $sms_sent_to_user = $gateway_url . "?token=$gateway_user_name" . "&device=$gateway_password" . "&phone=$clphone" . "&msg=" . urlencode($this->message);

                        $response = file_get_contents($sms_sent_to_user);
                        $response = json_decode($response, true);

                        if (is_array($response)) {
                            if (array_key_exists('code', $response)) {
                                if ($response['code'] == 0) {
                                    $get_sms_status = 'Success';
                                } else {
                                    $get_sms_status = $response['error'];
                                }
                            } else {
                                $get_sms_status = 'Unknown error';
                            }
                        } else {
                            $get_sms_status = 'Unknown error';
                        }
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }


                case 'Smsvitrini':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $message = urlencode($this->message);


                    $Parameter = "islem=1&user=$gateway_user_name&pass=$gateway_password&numaralar=$clphone&mesaj=$message&baslik=$this->sender_id";
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $Parameter);

                    $response = curl_exec($ch);
                    curl_close($ch);

                    $result = explode('|', $response);

                    if (is_array($result)) {

                        if (array_key_exists('1', $result)) {
                            if (strpos($result['1'], 'HATA') !== false) {
                                $get_sms_status = $result['2'];
                            } elseif (strpos($result['1'], 'OK') !== false) {
                                $get_sms_status = 'Success';
                            } else {
                                $get_sms_status = 'Bilinmeyen hata';
                            }
                        } else {
                            $get_sms_status = $result['2'];
                        }

                    } else {
                        $get_sms_status = 'Bilinmeyen hata';
                    }

                    break;

                case 'Semaphore':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $ch = curl_init();
                    $parameters = array(
                        'apikey' => $gateway_user_name, //Your API KEY
                        'number' => $clphone,
                        'message' => $this->message,
                        'sendername' => $this->sender_id
                    );
                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_POST, 1);

                    //Send the parameters set above with the request
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

                    // Receive response from server
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output = curl_exec($ch);
                    curl_close($ch);

                    $response = json_decode($output, true);

                    //Show the server response
                    if (is_array($response)) {
                        foreach ($response as $value) {
                            $get_sms_status = $value[0];
                        }

                    } else {
                        $get_sms_status = 'Unknown error';
                    }

                    break;

                case 'Itexmo':

                    $ch = curl_init();
                    $itexmo = array('1' => $this->cl_phone, '2' => $this->message, '3' => $gateway_user_name);
                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,
                        http_build_query($itexmo));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);

                    if ($response == 0) {
                        $get_sms_status = 'Success';
                    } elseif ($response == '') {
                        $get_sms_status = 'No response from server';
                    } else {
                        $get_sms_status = "Error Num " . $response . " was encountered!";
                    }

                    break;

                case 'Chikka':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $arr_post_body = array(
                        "message_type" => "SEND",
                        "mobile_number" => $clphone,
                        "shortcode" => $this->sender_id,
                        "message_id" => _raid(32),
                        "message" => urlencode($this->message),
                        "client_id" => $gateway_user_name,
                        "secret_key" => $gateway_password
                    );

                    $query_string = "";
                    foreach ($arr_post_body as $key => $frow) {
                        $query_string .= '&' . $key . '=' . $frow;
                    }

                    $curl_handler = curl_init();
                    curl_setopt($curl_handler, CURLOPT_URL, $gateway_url);
                    curl_setopt($curl_handler, CURLOPT_POST, count($arr_post_body));
                    curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $query_string);
                    curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, TRUE);
                    $response = curl_exec($curl_handler);
                    curl_close($curl_handler);

                    $response = json_decode($response, true);

                    if ($response['status'] == '200') {
                        $get_sms_status = 'Success';
                    } else {
                        $get_sms_status = $response['message'];
                    }

                    break;

                case '1s2u':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $message = $this->message;

                    if ($msg_type == 'unicode') {
                        $mt = 1;
                        $message = bin2hex(mb_convert_encoding($message, "UTF-16", "UTF-8"));
                    } else {
                        $mt = 0;
                        $message = urlencode($message);
                    }


                    $ch = curl_init();
                    $parameters = "username=$gateway_user_name&password=$gateway_password&mno=$clphone&msg=$message&sid=$this->sender_id&mt=$mt&fl=0&ipcl=$gateway_extra";
                    $gateway_url .= '?' . $parameters;
                    $gateway_url = str_replace(" ", '%20', $gateway_url);

                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_HTTPGET, 1);
                    // Receive response from server
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $output = curl_exec($ch);
                    curl_close($ch);

                    switch ($output) {
                        case '0000':
                            $get_sms_status = 'Message not sent';
                            break;
                        case '0005':
                            $get_sms_status = 'Invalid Sender';
                            break;
                        case '0010':
                            $get_sms_status = 'Username not provided';
                            break;
                        case '0011':
                            $get_sms_status = 'Password not provided';
                            break;
                        case '00':
                            $get_sms_status = 'Invalid username/password';
                            break;
                        case '0020':
                            $get_sms_status = 'Insufficient Credits';
                            break;
                        case '0030':
                            $get_sms_status = 'Invalid Sender ID';
                            break;
                        case '0040':
                            $get_sms_status = 'Mobile number not provided';
                            break;
                        case '0041':
                            $get_sms_status = 'Invalid mobile number';
                            break;
                        case '0042':
                            $get_sms_status = 'Network not supported';
                            break;
                        case '0050':
                            $get_sms_status = 'Invalid message';
                            break;
                        case '0060':
                            $get_sms_status = 'Invalid quantity specified';
                            break;
                        case '0066':
                            $get_sms_status = 'Network not supported';
                            break;
                        default:
                            $get_sms_status = 'Unknown Error';
                            break;
                    }

                    if (strlen($output) > 8) {
                        $get_sms_status = 'Success';
                    }

                    break;

                case 'Kaudal':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $message = urlencode($this->message);


                    $Parameter = "user=$gateway_user_name&password=$gateway_password&receive=$clphone&sms=$message&sender=$this->sender_id";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $Parameter);

                    $response = curl_exec($ch);
                    curl_close($ch);

                    $error_data = $response;

                    $response = filter_var($response, FILTER_SANITIZE_NUMBER_INT);
                    $response = str_replace('-', '', $response);


                    if ($response == '0') {
                        $get_sms_status = 'Success';
                    } else {
                        $details = explode('-', $error_data);
                        $get_sms_status = trim(strip_tags($details['2']));
                    }
                    break;

                case 'CMSMS':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $xml = new \SimpleXMLElement('<MESSAGES/>');

                    $authentication = $xml->addChild('AUTHENTICATION');
                    $authentication->addChild('PRODUCTTOKEN', $gateway_user_name);

                    $msg = $xml->addChild('MSG');
                    $msg->addChild('FROM', 'Company');
                    $msg->addChild('TO', $clphone);
                    $msg->addChild('BODY', $this->message);

                    $sms_data = $xml->asXML();

                    $ch = curl_init(); // cURL v7.18.1+ and OpenSSL 0.9.8j+ are required
                    curl_setopt_array($ch, array(
                            CURLOPT_URL => $gateway_url,
                            CURLOPT_HTTPHEADER => array('Content-Type: application/xml'),
                            CURLOPT_POST => true,
                            CURLOPT_POSTFIELDS => $sms_data,
                            CURLOPT_RETURNTRANSFER => true
                        )
                    );

                    $response = curl_exec($ch);

                    curl_close($ch);

                    if (strpos($response, 'OK') !== false) {
                        $get_sms_status = 'Success';
                    } else {

                        $status = explode(':', $response);

                        if (array_key_exists('1', $status)) {
                            $get_sms_status = $status['1'];
                        } else {
                            $get_sms_status = 'Unknown error';
                        }
                    }

                    break;
                case 'SendOut':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"api_id\": \"$gateway_user_name\",\"api_token\": \"$gateway_password\" ,\"debug\": \"true\",\"to\": [\"$clphone\"],\"sms\": \"$this->message\"} ");
                    curl_setopt($ch, CURLOPT_POST, 1);

                    $headers = array();
                    $headers[] = "Content-Type: application/json";
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    $get_sms_status = 'Unknown Error';
                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        $get_sms_status = curl_error($ch);
                    }

                    curl_close($ch);

                    if ($result) {
                        $get_result = json_decode($result);
                        if (array_key_exists('status', $get_result)) {
                            $get_sms_status = $get_result['status'];
                        }
                    }

                    break;


                case 'ViralThrob':

                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    $sms_url = rtrim($gateway_url, '/');

                    try {
                        $sms_sent_to_user = "$sms_url" . "?api_access_token=$gateway_user_name" . "&number=$this->cl_phone" . "&mask=$sender_id" . "&message=$message" . "&saas_account=" . $gateway_password;

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_status = curl_exec($ch);
                        curl_close($ch);

                        $get_status = json_decode($get_status);
                        $get_sms_status = $get_status->message;

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'Masterksnetworks':

                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    $sms_url = rtrim($gateway_url, '/');

                    try {
                        $sms_sent_to_user = "$sms_url" . "?username=$gateway_user_name" . "&mobile=$this->cl_phone" . "&sender=$sender_id" . "&message=$message" . "&password=" . $gateway_password . "&type=TEXT";

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_sms_status = curl_exec($ch);
                        curl_close($ch);
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'MessageBird':
                    $ch = curl_init();

                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "recipients=$this->cl_phone&originator=$this->sender_id&body=$this->message&datacoding=auto");
                    curl_setopt($ch, CURLOPT_POST, 1);

                    $headers = array();
                    $headers[] = "Authorization: AccessKey $gateway_user_name";
                    $headers[] = "Content-Type: application/x-www-form-urlencoded";
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        $get_sms_status = curl_error($ch);
                    }
                    curl_close($ch);

                    $response = json_decode($result, true);

                    if (array_key_exists('id', $response)) {
                        $get_sms_status = 'Success|' . $response['id'];
                    } elseif (array_key_exists('errors', $response)) {
                        $get_sms_status = $response['errors'][0]['description'];
                    } else {
                        $get_sms_status = 'Unknown Error';
                    }

                    break;


                case 'FortDigital':
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    $sms_url = rtrim($gateway_url, '/');

                    try {
                        $sms_sent_to_user = "$sms_url" . "?username=$gateway_user_name" . "&to=$this->cl_phone" . "&from=$sender_id" . "&message=$message" . "&password=" . $gateway_password;

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_sms_status = curl_exec($ch);
                        curl_close($ch);

                        if (strpos($get_sms_status, 'OK') !== false) {
                            $get_sms_status = 'Success';
                        } elseif (strpos($get_sms_status, 'ERROR:304') !== false) {
                            $get_sms_status = 'Authentication failed';
                        } elseif (strpos($get_sms_status, 'ERROR:000') !== false) {
                            $get_sms_status = 'Credit Balance Not Enough';
                        } else {
                            $get_sms_status = 'Unknown error';
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'SMSPRO':
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    $sms_url = rtrim($gateway_url, '/');
                    $defDate = date('Ymdhis', time());

                    try {
                        $sms_sent_to_user = "$sms_url" . "?customerID=$gateway_extra" . "&userName=$gateway_user_name" . "&userPassword=$gateway_password" . "&originator=$sender_id&messageType=Latin" . "&defDate=$defDate&blink=false&flash=false&private=true" . "&smsText=$message" . "&recipientPhone=$this->cl_phone";

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_sms_status = curl_exec($ch);
                        curl_close($ch);

                        $xml = simplexml_load_string($get_sms_status, "SimpleXMLElement", LIBXML_NOCDATA);
                        $json = json_encode($xml);
                        $array = json_decode($json, TRUE);

                        if (array_key_exists('Result', $array)) {
                            $get_response = $array['Result'];
                            if ($get_response = 'OK') {
                                $get_sms_status = 'Success';
                            } else {
                                $get_sms_status = preg_replace('/\D/', '', $get_response);
                            }


                        } else {
                            $get_sms_status = 'Unknown Error';
                        }


                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                        $get_sms_status = preg_replace('/\D/', '', $get_sms_status);
                    }


                    break;


                case 'CNIDCOM':
                    $message = urlencode($this->message);
                    $sms_url = rtrim($gateway_url, '/');

                    try {

                        $sms_sent_to_user = "$sms_url" . "?api_key=$gateway_user_name" . "&numero=$this->cl_phone" . "&remitente=$this->sender_id" . "&texto=$message" . "&api_secret=" . $gateway_password;

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_sms_status = curl_exec($ch);
                        curl_close($ch);


                        $get_data = json_decode($get_sms_status, true);


                        if (json_last_error() == JSON_ERROR_NONE) {
                            if (array_key_exists('Saldo', $get_data)) {
                                $get_sms_status = 'Success';
                            } else {
                                $get_sms_status = 'Unknown error';
                            }
                        } else {
                            $get_sms_status = trim($get_sms_status);
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'VoiceTrading':
                    $message = urlencode($this->message);
                    $sms_url = rtrim($gateway_url, '/');

                    try {

                        $sms_sent_to_user = "$sms_url" . "?username=$gateway_user_name" . "&password=$gateway_password" . "&from=$this->sender_id" . "&to=$this->cl_phone" . "&text=" . $message;

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_sms_status = curl_exec($ch);
                        curl_close($ch);

                        if (strpos($get_sms_status, 'success') !== false) {
                            $get_sms_status = 'Success';
                        } elseif (strpos($get_sms_status, 'Invalid Number') !== false) {
                            $get_sms_status = 'Invalid Number';
                        } elseif (strpos($get_sms_status, 'you do not have enough credit') !== false) {
                            $get_sms_status = 'Insufficient balance';
                        } elseif (strpos($get_sms_status, 'Wrong Username/password combination') !== false) {
                            $get_sms_status = 'Wrong Username/password combination';
                        } elseif (strpos($get_sms_status, 'The parameter password is missing') !== false) {
                            $get_sms_status = 'The parameter password is missing';
                        } else {
                            $get_sms_status = 'Unknown error';
                        }

                        $get_data = json_decode($get_sms_status, true);


                        if (json_last_error() == JSON_ERROR_NONE) {
                            if (array_key_exists('Saldo', $get_data)) {
                                $get_sms_status = 'Success';
                            } else {
                                $get_sms_status = 'Unknown error';
                            }
                        } else {
                            $get_sms_status = trim($get_sms_status);
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;


                case 'Dialog':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $message = urlencode($this->message);
                    $sms_url = rtrim($gateway_url, '/');

                    try {

                        $sms_sent_to_user = "$sms_url" . "?q=$gateway_user_name" . "&from=$this->sender_id" . "&destination=$clphone" . "&message=" . $message;

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_sms_status = curl_exec($ch);
                        curl_close($ch);
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'AmazonSNS':

                    $params = array(
                        'credentials' => array(
                            'key' => $gateway_user_name,
                            'secret' => $gateway_password,
                        ),
                        'region' => $gateway_extra, // < your aws from SNS Topic region
                        'version' => 'latest'
                    );

                    $sns = new SnsClient($params);


                    $args = array(
                        'MessageAttributes' => [
                            'AWS.SNS.SMS.SenderID' => [
                                'DataType' => 'String',
                                'StringValue' => $this->sender_id
                            ]
                        ],
                        "SMSType" => "Transational",
                        "PhoneNumber" => '+'.$this->cl_phone,
                        "Message" => $this->message
                    );


                    try {

                        $result = $sns->publish($args)->toArray();

                        if (is_array($result) && array_key_exists('MessageId', $result)) {
                            $get_sms_status = 'Success|' . $result['MessageId'];
                        } else {
                            $get_sms_status = 'Unknown error';
                        }
                    } catch (SnsException $e) {
                        $get_sms_status = $e->getAwsErrorMessage();
                    }

                    break;


                case 'NusaSMS':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => $gateway_url,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => array(
                            'user' => $gateway_user_name,
                            'password' => $gateway_password,
                            'SMSText' => $this->message,
                            'GSM' => $clphone,
                            'output' => 'json'
                        )
                    ));
                    $resp = curl_exec($curl);
                    if (!$resp) {
                        $get_sms_status = 'Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl);
                    } else {
                        $get_sms_status = $resp;
                    }
                    curl_close($curl);

                    $get_sms_status = json_decode($get_sms_status, true);

                    if (is_array($get_sms_status) && array_key_exists('results', $get_sms_status)) {
                        $status = $get_sms_status['results'][0]['status'];

                        switch ($status) {
                            case '0':
                                $get_sms_status = 'Success';
                                break;
                            case '-1':
                                $get_sms_status = 'Error in processing the request';
                                break;
                            case '-2':
                                $get_sms_status = 'Not enough credits on a specific account';
                                break;
                            case '-3':
                                $get_sms_status = 'Targeted network is not covered on specific account';
                                break;
                            case '-5':
                                $get_sms_status = 'Username or password is invalid';
                                break;
                            case '-6':
                                $get_sms_status = 'Destination address is missing in the request';
                                break;
                            case '-7':
                                $get_sms_status = 'Balance has expired';
                                break;
                            case '-11':
                                $get_sms_status = 'Number is not recognized by NusaSMS platform';
                                break;
                            case '-12':
                                $get_sms_status = 'Message is missing in the request';
                                break;
                            case '-13':
                                $get_sms_status = 'Number is not recognized by NusaSMS platform';
                                break;
                            case '-22':
                                $get_sms_status = 'Incorrect XML format, caused by syntax error';
                                break;
                            case '-23':
                                $get_sms_status = 'General error, reasons may vary';
                                break;
                            case '-26':
                                $get_sms_status = 'General API error, reasons may vary';
                                break;
                            case '-27':
                                $get_sms_status = 'Invalid scheduling parametar';
                                break;
                            case '-28':
                                $get_sms_status = 'Invalid PushURL in the request';
                                break;
                            case '-30':
                                $get_sms_status = 'Invalid APPID in the request';
                                break;
                            case '-33':
                                $get_sms_status = 'Duplicated MessageID in the request';
                                break;
                            case '-34':
                                $get_sms_status = 'Sender name is not allowed';
                                break;
                            case '-40':
                                $get_sms_status = 'Client IP Address Not In White List';
                                break;
                            case '-99':
                                $get_sms_status = '	Error in processing request, reasons may vary';
                                break;

                            default:
                                $get_sms_status = 'Unknown error';
                                break;
                        }

                    }


                    break;


                case 'SMS4Brands':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    try {
                        $sms_sent_to_user = $gateway_url . "?username=$gateway_user_name" . "&password=$gateway_password" . "&phone=$clphone" . "&sender=$sender_id" . "&message=$message";


                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_sms_status = curl_exec($ch);
                        curl_close($ch);

                        $get_sms_status = trim($get_sms_status);

                        if ($get_sms_status == 'Sent') {
                            $get_sms_status = 'Success';
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;


                case 'CheapGlobalSMS':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $post_data = array(
                        'sub_account' => $gateway_user_name,
                        'sub_account_pass' => $gateway_password,
                        'action' => 'send_sms',
                        'sender_id' => $this->sender_id,
                        'recipients' => $clphone,
                        'message' => $this->message
                    );

                    if ($msg_type == 'unicode') {
                        $post_data['unicode'] = 1;
                    }

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $gateway_url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec($ch);
                    $response_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    if ($response_code != 200) {
                        $get_sms_status = curl_error($ch);
                    }
                    curl_close($ch);
                    if ($response_code != 200) {
                        $get_sms_status = "HTTP ERROR $response_code: $response";
                    } else {
                        $json = @json_decode($response, true);

                        if ($json === null) {
                            $get_sms_status = "INVALID RESPONSE: $response";
                        } elseif (!empty($json['error'])) {
                            $get_sms_status = $json['error'];
                        } else {
                            $get_sms_status = 'Success|' . $json['batch_id'];
                        }
                    }

                    break;


                case 'ExpertTexting':


                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    $sms_url = rtrim($gateway_url, '/');
                    try {
                        $sms_sent_to_user = "$sms_url" . "?username=$gateway_user_name" . "&api_key=$gateway_extra" . "&to=$clphone" . "&from=$sender_id" . "&text=$message" . "&password=" . $gateway_password . "&type=TEXT";

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_response = curl_exec($ch);
                        curl_close($ch);

                        $result = json_decode($get_response, true);

                        if (is_array($result) && array_key_exists('Response', $result)) {
                            if ($result['Response'] == null) {
                                $get_sms_status = $result['ErrorMessage'];
                            }

                            if ($result['Status'] == 0) {
                                $get_sms_status = 'Success';
                            }

                        } else {
                            $get_sms_status = 'Unknown error';
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;


                case 'LightSMS':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $sms_url = rtrim($gateway_url, '/');
                    $timestamp = file_get_contents('https://www.lightsms.com/external/get/timestamp.php');

                    $params = [
                        'login' => $gateway_user_name,
                        'phone' => $clphone,
                        'sender' => $this->sender_id,
                        'text' => $this->message,
                        'timestamp' => $timestamp,
                        'return' => 'json'
                    ];
                    ksort($params);


                    $signature = md5(implode($params) . $gateway_password);

                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);


                    try {
                        $url = "$sms_url" . "?login=$gateway_user_name" . "&signature=$signature" . "&phone=$clphone" . "&sender=$sender_id" . '&timestamp=' . $timestamp . "&return=json" . "&text=$message";
                        $get_response = file_get_contents($url);

                        $result = json_decode($get_response, true);

                        if (is_array($result) && array_key_exists($clphone, $result)) {

                            if (!empty($result[$clphone]) && is_array($result[$clphone]) && array_key_exists('error', $result[$clphone])) {
                                if ($result[$clphone]['error'] != 0) {
                                    $get_sms_status = $result[$clphone]['error'];
                                } else {
                                    $get_sms_status = 'Success';
                                }
                            } else {
                                $get_sms_status = 'Unknown error';
                            }
                        } else {
                            $get_sms_status = 'Unknown error';
                        }
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;


                case 'Adicis':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sms_url = rtrim($gateway_url, '/');
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    $rand = str_random(2);

                    try {
                        $sms_sent_to_user = "$sms_url" . "?user=$gateway_user_name" . "&pass=$gateway_password" . "&phone=$clphone" . "&sender=$sender_id" . '&msg_uid=' . $rand . "&action=submit" . "&msg_text=$message";
                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_response = curl_exec($ch);
                        curl_close($ch);
                        if (strpos($get_response, 'successfully') !== false) {
                            $get_sms_status = 'Success';
                        } else {
                            $get_sms_status = $get_response;
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'Smsconnexion':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sms_url = rtrim($gateway_url, '/');
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);


                    $Url = $sms_url . "?action=send&username=" . $gateway_user_name . "&passphrase=" . $gateway_password . "&message=" . $message . "&phone=" . $clphone;
                    if (!empty($sender_id)) {
                        $Url = $Url . "&from=" . $sender_id;
                    }
                    // is curl installed?
                    if (!function_exists('curl_init')) {
                        $get_sms_status = 'CURL is not installed';
                    }

                    // create a new curl resource
                    $ch = curl_init();

                    // set URL to download
                    curl_setopt($ch, CURLOPT_URL, $Url);

                    // remove header? 0 = yes, 1 = no
                    curl_setopt($ch, CURLOPT_HEADER, 0);

                    // should curl return or print the data? true = return, false = print
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    // timeout in seconds
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

                    // download the given URL, and return output
                    $get_sms_status = curl_exec($ch);

                    // close the curl resource, and free system resources
                    curl_close($ch);


                    $get_sms_status = trim(str_replace(',', '', $get_sms_status));

                    if (ctype_digit($get_sms_status)) {
                        $get_sms_status = 'Success';
                    }

                    break;


                case 'BrandedSMS':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    try {
                        $sms_sent_to_user = $gateway_url . "?username=$gateway_user_name" . "&password=$gateway_password" . "&phone=$clphone" . "&sender=$sender_id" . "&message=$message";


                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_sms_status = curl_exec($ch);
                        curl_close($ch);

                        $get_sms_status = trim($get_sms_status);

                        if ($get_sms_status == '1') {
                            $get_sms_status = 'Success';
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'Ibrbd':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    try {
                        $sms_sent_to_user = $gateway_url . "?user=$gateway_user_name" . "&pass=$gateway_password" . "&number=$clphone" . "&yourid=$sender_id" . "&content=$message";


                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_response = curl_exec($ch);
                        curl_close($ch);
                        $result = json_decode($get_response, true);

                        if (is_array($result) && array_key_exists('status', $result)) {
                            $get_sms_status = $result['status'];
                        } else {
                            $get_sms_status = 'Invalid request';
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'TxtNation':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    // These are the POST parameters to set to send a free
                    // msg
                    $req = 'reply=0';
                    $req .= '&id=' . uniqid();
                    $req .= '&number=' . $clphone;
                    $req .= '&network=INTERNATIONAL';
                    $req .= '&message=' . $this->message;
                    $req .= '&value=0';
                    $req .= '&currency=GBP';
                    $req .= '&cc=' . $gateway_user_name;
                    $req .= '&title=' . $this->sender_id;
                    $req .= '&ekey=' . $gateway_password;

                    // Now use the cURL library to make the POST happen
                    $ch = curl_init();

                    // Set the options to make it POST and return the
                    // result (also timeout if no connection after 10
                    // seconds)
                    curl_setopt_array($ch, array(

                        CURLOPT_URL => $gateway_url,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => $req,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_CONNECTTIMEOUT => 10
                    ));

                    // Do the send
                    $result = curl_exec($ch);

                    // Now we have a result we can free the connection
                    curl_close($ch);

                    // Check to see if the post is a success
                    if (strstr($result, 'SUCCESS')) {
                        $get_sms_status = 'Success';
                    } elseif (strstr($result, '103')) {
                        $get_sms_status = 'An invalid E-Key';
                    } elseif (strstr($result, '101')) {
                        $get_sms_status = 'Duplicate post back for message ID';
                    } elseif (strstr($result, '102')) {
                        $get_sms_status = 'Binary transaction requested, but no UDH specified';
                    } elseif (strstr($result, '104')) {
                        $get_sms_status = 'Invalid details. Please check and try again';
                    } elseif (strstr($result, '415')) {
                        $get_sms_status = 'Invalid company code sent';
                    } elseif (strstr($result, 'BARRED')) {
                        $get_sms_status = 'MSISDN has sent a STOP request or is blacklisted';
                    } elseif (strstr($result, 'NO CREDITS')) {
                        $get_sms_status = 'Inefficient balance';
                    } else {
                        $get_sms_status = 'Unknown error';
                    }


                    break;

                case 'TeleSign':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $messaging_client = new MessagingClient($gateway_user_name, $gateway_password);
                    $response = $messaging_client->message($clphone, $this->message, 'ARN');
                    $get_status = $response->json;

                    if (is_array($get_status) && array_key_exists('status', $get_status)) {
                        if (is_array($get_status['status']) && array_key_exists('description', $get_status['status']) && array_key_exists('code', $get_status['status'])) {
                            if ($get_status['status']['code'] == '290') {
                                $get_sms_status = 'Success';
                            } else {
                                $get_sms_status = $get_status['status']['description'];
                            }
                        } else {
                            $get_sms_status = 'Invalid request';
                        }
                    } else {
                        $get_sms_status = 'Unknown error';
                    }


                    break;

                case 'JasminSMS':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = urlencode($clphone);
                    $message = urlencode($this->message);

                    try {
                        $sms_sent_to_user = $gateway_url . ':' . $gateway_extra . "/send?username=$gateway_user_name" . "&password=$gateway_password" . "&to=$clphone" . "&content=$message";

                        $get_sms_status = file_get_contents($sms_sent_to_user);

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }
                    break;

                case 'Ezeee':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    try {
                        $sms_sent_to_user = $gateway_url . "?Username=$gateway_user_name" . "&Password=$gateway_password" . "&to=$clphone" . "&From=$sender_id" . "&Message=$message";

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_sms_status = curl_exec($ch);
                        curl_close($ch);
                        if (substr_count($get_sms_status, 'Sent Successfully')) {
                            $get_sms_status = 'Success';
                        }
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'Moreify':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace(['+', '(', ')', '-'], '', $clphone);

                    $postParams = array(
                        'project' => $gateway_user_name,
                        'password' => $gateway_password,
                        'phonenumber' => $clphone,
                        'message' => $this->message,
                        'tag' => $this->sender_id
                    );

                    $curl = curl_init($gateway_url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $postParams);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                    $get_response = curl_exec($curl);
                    curl_close($curl);

                    $result = json_decode($get_response, true);

                    if (is_array($result) && array_key_exists('success', $result)) {
                        if ($result['success'] != '') {
                            $get_sms_status = 'Success';
                        } else {
                            $get_sms_status = $result['errorMessage'];
                        }
                    } else {
                        $get_sms_status = 'Invalid request';
                    }

                    break;

                case 'Digitalreachapi':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);

                    $url = 'https://digitalreachapi.dialog.lk/refresh_token.php';

                    // DATA JASON ENCODED
                    $data = array("u_name" => $gateway_user_name, "passwd" => $gateway_password);
                    $data_json = json_encode($data);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);

                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    // DATA ARRAY
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);

                    if ($response === false) {
                        $get_sms_status = curl_error($ch);
                    }
                    curl_close($ch);

                    $response = json_decode($response, true);

                    if (is_array($response) && array_key_exists('access_token', $response)) {
                        $access_token = $response['access_token'];

                        $data = array(
                            "msisdn" => $clphone,
                            "channel" => "1",
                            "mt_port" => $this->sender_id,
                            "s_time" => date("Y-m-d H:i:s"),
                            "e_time" => date('Y-m-d H:i:s', strtotime("+30 minutes")),
                            "msg" => $this->message,
                        );
                        $data_json = json_encode($data);

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $gateway_url);

                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', "Authorization:$access_token"));
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                        // DATA ARRAY
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);

                        if ($response === false) {
                            $get_sms_status = curl_error($ch);
                        }
                        curl_close($ch);

                        $response = json_decode($response, true);

                        if (is_array($response) && array_key_exists('error', $response)) {
                            switch ($response['error']) {

                                case 0:
                                    $get_sms_status = 'Success';
                                    break;

                                case '101':
                                    $get_sms_status = 'Error in parameter';
                                    break;

                                case '102':
                                    $get_sms_status = 'Global throttle exceeds';
                                    break;

                                case '103':
                                    $get_sms_status = 'User wise throttle exceeds';
                                    break;

                                case '104':
                                    $get_sms_status = 'Invalid token';
                                    break;

                                case '105':
                                    $get_sms_status = 'User is blocked';
                                    break;

                                case '106':
                                    $get_sms_status = 'Invalid channel type';
                                    break;

                                case '107':
                                    $get_sms_status = 'Invalid Sender ID';
                                    break;

                                case '108':
                                    $get_sms_status = 'Error in time frame';
                                    break;

                                case '109':
                                    $get_sms_status = 'Insufficient balance';
                                    break;

                                case '110':
                                    $get_sms_status = 'Invalid Number';
                                    break;

                                case '111':
                                    $get_sms_status = 'Invalid message type';
                                    break;

                                case '112':
                                    $get_sms_status = 'Max ad length allowed for selected channel exceed';
                                    break;

                                default:
                                    $get_sms_status = 'Unknown error';
                                    break;

                            }
                        } else {
                            $get_sms_status = 'Unknown error';
                        }

                    } elseif (is_array($response) && array_key_exists('error', $response)) {
                        if ($response['error'] == 100) {
                            $get_sms_status = 'Invalid credentials';
                        } elseif ($response['error'] == 101) {
                            $get_sms_status = 'Error in parameter';
                        } else {
                            $get_sms_status = 'Unknown error';
                        }
                    } else {
                        $get_sms_status = 'Unknown error';
                    }

                    break;

                case 'Tropo':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace(['+', '(', ')', '-'], '', $clphone);

                    try {
                        $sms_sent_to_user = $gateway_url . "?action=create&token=$gateway_user_name" . "&numberToDial=$clphone" . "&msg=$this->message";

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $response = curl_exec($ch);
                        curl_close($ch);

                        $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
                        $json = json_encode($xml);
                        $get_data = json_decode($json, TRUE);
                        if (is_array($get_data) && array_key_exists('success', $get_data)) {
                            if ($get_data['success'] == false) {
                                $get_sms_status = $get_data['reason'];
                            } else {
                                $get_sms_status = 'Success';
                            }
                        } else {
                            $get_sms_status = 'Invalid Request';
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;

                case 'CheapSMS':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    try {
                        $sms_sent_to_user = $gateway_url . "?loginID=$gateway_user_name" . "&password=$gateway_password" . "&mobile=$clphone" . "&senderid=$sender_id" . "&text=$message" . "&route_id=7";

                        if ($msg_type == 'unicode') {
                            $sms_sent_to_user .= "&Unicode=1";
                        } else {
                            $sms_sent_to_user .= "&Unicode=0";
                        }

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_data = curl_exec($ch);
                        curl_close($ch);

                        $get_data = json_decode($get_data, true);
                        if (is_array($get_data) && array_key_exists('LoginStatus', $get_data)) {
                            if ($get_data['LoginStatus'] == 'Success') {
                                if ($get_data['Transaction_ID'] != '') {
                                    $get_sms_status = 'Success';
                                } else {
                                    $get_sms_status = $get_data['MsgStatus'];
                                }
                            } else {
                                $get_sms_status = $get_data['LoginStatus'];
                            }
                        } else {
                            $get_sms_status = 'Unknown error';
                        }
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }
                    break;


                case 'CCSSMS':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace('+', '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    try {

                        $sms_sent_to_user = $gateway_url . "?username=$gateway_user_name" . "&password=$gateway_password" . "&dnis=$clphone" . "&ani=$sender_id" . "&message=$message" . "&command=submit&longMessageMode=1";

                        if ($msg_type == 'unicode') {
                            $sms_sent_to_user .= "&dataCoding=1";
                        } else {
                            $sms_sent_to_user .= "&dataCoding=0";
                        }

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_data = curl_exec($ch);
                        curl_close($ch);
                        $get_data = json_decode($get_data, true);

                        if (is_array($get_data)) {
                            if (array_key_exists('message_id', $get_data)) {
                                $get_sms_status = 'Success';
                            }
                        } else {
                            $get_sms_status = 'Set your Ip in whitelist';
                        }
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }
                    break;


                case 'MyCoolSMS':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace(['+', '(', ')', '-'], '', $clphone);

                    $postParams = array(
                        'username' => $gateway_user_name,
                        'password' => $gateway_password,
                        'function' => 'sendSms',
                        'number' => $clphone,
                        'senderid' => $this->sender_id,
                        'message' => $this->message
                    );

                    $curl = curl_init($gateway_url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postParams));
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                    $get_response = curl_exec($curl);
                    curl_close($curl);

                    $result = json_decode($get_response, true);

                    if (is_array($result) && array_key_exists('success', $result)) {
                        if ($result['success'] == true) {
                            $get_sms_status = 'Success';
                        } else {
                            $get_sms_status = $result['description'];
                        }
                    } else {
                        $get_sms_status = 'Invalid request';
                    }

                    break;


                case 'SmsBump':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace(['+', '(', ')', '-'], '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);

                    try {

                        $sms_sent_to_user = $gateway_url . "/$gateway_user_name.json?to=$clphone" . "&from=$sender_id" . "&message=$message" . "&type=sms";

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_data = curl_exec($ch);
                        curl_close($ch);
                        $result = json_decode($get_data, true);

                        if (is_array($result) && array_key_exists('status', $result)) {
                            if ($result['status'] == 'OK' || $result['status'] == 'queued') {
                                $get_sms_status = 'Success';
                            } elseif ($result['status'] == 'error') {
                                $get_sms_status = $result['message'];
                            } else {
                                $get_sms_status = 'Unknown error';
                            }
                        } else {
                            $get_sms_status = 'Invalid request';
                        }
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }
                    break;


                case 'BSG':
                    require_once(app_path('libraray/bsg/BSG.php'));

                    $bsg = new \BSG($gateway_user_name);

                    try {

                        $smsClient = $bsg->getSmsClient();
                        $get_data = $smsClient->sendSms(
                            $this->cl_phone,
                            $this->message,
                            _raid(5),
                            '72',
                            '9',
                            $this->sender_id
                        );

                        if (is_array($get_data) && array_key_exists('error', $get_data)) {
                            if ($get_data['error'] == 0) {
                                $get_sms_status = 'Success';
                            } else {
                                $get_sms_status = $get_data['errorDescription'];
                            }
                        } elseif (is_array($get_data) && array_key_exists('result', $get_data)) {
                            if ($get_data['result']['error'] == 0) {
                                $get_sms_status = 'Success';
                            } else {
                                $get_sms_status = $get_data['result']['errorDescription'];
                            }
                        } else {
                            $get_sms_status = 'Unknown error';
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;


                case 'SmsBroadcast':
                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace(['+', '(', ')', '-'], '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);
                    try {

                        $sms_sent_to_user = $gateway_url . "?username=$gateway_user_name" . "&password=$gateway_password" . "&to=$clphone" . "&from=$sender_id" . "&message=$message";

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_data = curl_exec($ch);
                        curl_close($ch);

                        $response_lines = explode("\n", $get_data);

                        if (is_array($response_lines)) {
                            foreach ($response_lines as $data_line) {

                                $get_response = explode(':', $data_line);

                                if ($get_response[0] == "OK") {
                                    $get_sms_status = 'Success';
                                } elseif ($get_response[0] == "BAD") {
                                    $get_sms_status = $get_response[2];
                                } elseif ($get_response[0] == "ERROR") {
                                    $get_sms_status = $get_response[1];
                                } else {
                                    $get_sms_status = 'Unknown error';
                                }
                            }
                        } else {
                            $get_sms_status = 'Invalid request';
                        }


                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }

                    break;


                case 'BullSMS':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace(['+', '(', ')', '-'], '', $clphone);
                    $sender_id = urlencode($this->sender_id);
                    $message = urlencode($this->message);

                    try {

                        $sms_sent_to_user = $gateway_url . "?user=$gateway_user_name" . "&password=$gateway_password" . "&msisdn=$clphone" . "&sid=$sender_id" . "&msg=$message" . "&fl=0";

                        $ch = curl_init();

                        curl_setopt($ch, CURLOPT_URL, $sms_sent_to_user);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        $get_data = curl_exec($ch);
                        curl_close($ch);
                        $result = json_decode($get_data, true);

                        if (is_array($result) && array_key_exists('ErrorMessage', $result)) {
                            $get_sms_status = $result['ErrorMessage'];
                        } else {
                            $get_sms_status = 'Unknown error';
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }
                    break;


                case 'Skebby':

                    $clphone = str_replace(" ", "", $this->cl_phone); #Remove any whitespace
                    $clphone = str_replace(['+', '(', ')', '-'], '', $clphone);

                    $postData = array(
                        'message_type' => 'GP',
                        'message' => $this->message,
                        'recipient' => [$clphone],
                        'sender' => $this->sender_id,
                    );

                    $payload = json_encode($postData);

                    try {

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $gateway_url);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            "Content-type: application/json",
                            "user_key: $gateway_user_name",
                            "Session_key: $gateway_password"
                        ));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                        $response = curl_exec($ch);
                        curl_close($ch);

                        $obj = json_decode($response,true);

                        if (is_array($obj) && array_key_exists('code',$obj)){
                            if ($obj['code'] == 201){
                                $get_sms_status = 'Success';
                            }else{
                                $get_sms_status = $obj['error_message'];
                            }
                        }else{
                            $get_sms_status = 'Unknown error';
                        }

                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }
                    break;

                case 'InfoBipSMPP':
                case 'SMSGlobalSMPP':
                case 'ClickatellSMPP':
                case 'WavecellSMPP':
                case 'JasminSmsSMPP':
                    include_once app_path('Classes/Smpp.php');
                    header('Content-Type: text/plain');

                    $src = $this->sender_id; // or text
                    $dst = $this->cl_phone;
                    $message = $this->message;


                    try {
                        $s = new \smpp();
                        $s->debug = 0;

                        // $host,$port,$system_id,$password
                        $s->open($gateway_url, $gateway_extra, $gateway_user_name, $gateway_password);


                        /* To send unicode*/
                        if ($msg_type == 'unicode') {
                            $utf = true;
                            $message = iconv('Windows-1256', 'UTF-16BE', $message);
                            $get_sms_status = $s->send_long($src, $dst, $message, $utf);
                        } else {
                            // $source_addr,$destintation_addr,$short_message,$utf=0,$flash=0
                            $get_sms_status = $s->send_long($src, $dst, $message);
                        }


                        $s->close();

                        if ($get_sms_status === true) {
                            $get_sms_status = 'Success';
                        }
                    } catch (\Exception $e) {
                        $get_sms_status = $e->getMessage();
                    }


                    break;

                case 'default':
                    $get_sms_status = 'Gateway not found';
                    break;

            }

        }

        if ($this->api_key != '') {
            $send_by = 'api';
        } else {
            $send_by = 'sender';
        }


        SMSHistory::create([
            'userid' => $this->user_id,
            'sender' => $this->sender_id,
            'receiver' => (string)$this->cl_phone,
            'message' => $this->message,
            'amount' => $this->msgcount,
            'status' => $get_sms_status,
            'api_key' => $this->api_key,
            'use_gateway' => $gateway_name,
            'send_by' => $send_by
        ]);

        if ($this->user_id != '0') {
            $client = Client::find($this->user_id);
            if (substr_count($get_sms_status, 'Success') == 0) {
                $client->sms_limit += 1;
                $client->save();
            }
        }

        $this->get_sms_status = $get_sms_status;

    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->get_sms_status;
    }
}
