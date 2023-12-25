<?php

namespace App\Http\Controllers;

use App\Classes\PhoneNumber;
use App\Client;
use App\CustomSMSGateways;
use App\IntCountryCodes;
use App\Jobs\SendBulkSMS;
use App\SenderIdManage;
use App\SMSGateways;
use App\SMSHistory;
use App\SMSInbox;
use Illuminate\Http\Request;
use libphonenumber\PhoneNumberUtil;

class PublicAccessController extends Controller
{

    //======================================================================
    // ultimateSMSApi Function Start Here
    //======================================================================
    public function ultimateSMSApi(Request $request)
    {

        $action = $request->input('action');
        $api_key = $request->input('api_key');
        $to = $request->input('to');
        $from = $request->input('from');
        $sms = $request->input('sms');
        $unicode = $request->input('unicode');

        if ($action == '' && $api_key == '') {
            return response()->json([
                'code' => '100',
                'message' => 'Bad gateway requested'
            ]);
        }

        switch ($action) {
            case 'send-sms':

                if ($to == '' && $from == '' && $sms == '' && $unicode == '') {
                    return response()->json([
                        'code' => '100',
                        'message' => 'Bad gateway requested'
                    ]);
                }


                $isValid = PhoneNumberUtil::isViablePhoneNumber($to);

                if (!$isValid) {
                    return response()->json([
                        'code' => '103',
                        'message' => 'Invalid Phone Number'
                    ]);
                }


                if ($unicode == '0') {
                    $msg_type = 'plain';
                    $msgcount = strlen(preg_replace('/\s+/', ' ', trim($sms)));
                    if ($msgcount <= 160) {
                        $msgcount = 1;
                    } else {
                        $msgcount = $msgcount / 157;
                    }
                }
                if ($unicode == '1') {
                    $msg_type = 'unicode';
                    $msgcount = mb_strlen(preg_replace('/\s+/', ' ', trim($sms)),'UTF-8');

                    if ($msgcount <= 70) {
                        $msgcount = 1;
                    } else {
                        $msgcount = $msgcount / 67;
                    }
                }

                $msgcount = ceil($msgcount);

                if (app_config('api_key') == $api_key) {
                    $gateway = SMSGateways::find(app_config('sms_api_gateway'));
                    if ($gateway->custom == 'Yes') {
                        $cg_info = CustomSMSGateways::where('gateway_id', app_config('sms_api_gateway'))->first();
                    } else {
                        $cg_info = '';
                    }

                    $user_id = '0';

                    $this->dispatch(new SendBulkSMS($user_id, $to, $gateway, $from, $sms, $msgcount, $cg_info, $api_key,$msg_type));

                    return response()->json([
                        'code' => 'ok',
                        'message' => 'Successfully Send',
                        'balance' => 'Unlimited',
                        'user' => 'Admin'
                    ]);

                } else {
                    $client = Client::where('api_key', $api_key)->where('api_access', 'Yes')->first();
                    if ($client) {
                        $user_id = $client->id;


                        if ($from != '' && app_config('sender_id_verification') == '1') {

                            $all_sender_id = SenderIdManage::where('status','unblock')->get();
                            $all_ids = [];

                            foreach ($all_sender_id as $sid) {
                                $client_array = json_decode($sid->cl_id);

                                if (in_array('0', $client_array)) {
                                    array_push($all_ids, $from);
                                } elseif (in_array($client->id, $client_array)) {
                                    array_push($all_ids, $sid->sender_id);
                                }
                            }

                            $all_ids = array_unique($all_ids);

                            if (!in_array($from, $all_ids)) {
                                return response()->json([
                                    'code' => '106',
                                    'message' => 'Invalid Sender id'
                                ]);
                            }
                        }
                        

                        $gateway = SMSGateways::find($client->sms_gateway);
                        if ($gateway->custom == 'Yes') {
                            $cg_info = CustomSMSGateways::where('gateway_id', $client->sms_gateway)->first();
                        } else {
                            $cg_info = '';
                        }

                        $phone = str_replace(['(', ')', '+', '-', ' '], '', trim($to));
                        $c_phone = PhoneNumber::get_code($phone);

                        $sms_cost = IntCountryCodes::where('country_code', $c_phone)->where('active', '1')->first();

                        if ($sms_cost) {
                            $sms_charge = $sms_cost->tariff;
                            $total_cost = $sms_charge * $msgcount;

                            if ($total_cost == 0) {
                                return response()->json([
                                    'code' => '105',
                                    'message' => 'Insufficient balance'
                                ]);
                            }

                            if ($total_cost > $client->sms_limit) {
                                return response()->json([
                                    'code' => '105',
                                    'message' => 'Insufficient balance'
                                ]);
                            }

                            $remain_sms = $client->sms_limit - $total_cost;
                            $client->sms_limit = $remain_sms;
                            $client->save();

                            $this->dispatch(new SendBulkSMS($user_id, $to, $gateway, $from, $sms, $msgcount, $cg_info, $api_key,$msg_type));
                            $balance = round($client->sms_limit);
                            return response()->json([
                                'code' => 'ok',
                                'message' => 'Successfully Send',
                                'balance' => $balance,
                                'user' => $client->fname . ' ' . $client->lname
                            ]);

                        } else {
                            return response()->json([
                                'code' => '104',
                                'message' => 'Phone coverage not active'
                            ]);
                        }

                    } else {
                        return response()->json([
                            'code' => '102',
                            'message' => 'Authentication Failed'
                        ]);
                    }
                }
                break;

            case 'get-inbox':
                $all_messages = SMSHistory::where('api_key', $api_key)->select('id', 'sender', 'receiver')->get();
                $return_data = [];
                $all_message = [];
                foreach ($all_messages as $msg) {
                    $return_data['id'] = $msg->id;
                    $return_data['from'] = $msg->sender;
                    $return_data['phone'] = $msg->receiver;
                    $return_data['sms'] = $msg->message;
                    $return_data['segments'] = $msg->amount;
                    $return_data['status'] = $msg->status;
                    $return_data['type'] = $msg->sms_type;
                    array_push($all_message, $return_data);
                }

                return response()->json($all_message);

                break;

            case 'check-balance':
                if (app_config('api_key') == $api_key) {

                    return response()->json([
                        'balance' => 'Unlimited',
                        'user' => 'Admin',
                        'country' => app_config('Country')
                    ]);

                } else {
                    $client = Client::where('api_key', $api_key)->where('api_access', 'Yes')->first();
                    if ($client) {
                        $balance = round($client->sms_limit);

                        return response()->json([
                            'balance' => $balance,
                            'user' => $client->fname . ' ' . $client->lname,
                            'country' => $client->country
                        ]);
                    } else {
                        return response()->json([
                            'code' => '102',
                            'message' => 'Authentication Failed'
                        ]);
                    }
                }
                break;

            default:
                return response()->json([
                    'code' => '101',
                    'message' => 'Wrong action'
                ]);
                break;
        }

    }


    //======================================================================
    // insertSMS Function Start Here
    //======================================================================
    public function insertSMS($number, $msg_count, $body, $to = '', $gateway = '')
    {
        $get_info = SMSHistory::where('receiver', 'like', '%' . $number)->orderBy('id', 'desc')->first();

        if ($get_info) {
            $status = SMSHistory::create([
                'userid' => $get_info->userid,
                'sender' => $number,
                'receiver' => $to,
                'message' => $body,
                'amount' => $msg_count,
                'status' => 'Success',
                'api_key' => null,
                'use_gateway' => $gateway,
                'send_by' => 'receiver',
                'sms_type' => 'text'
            ]);

            if ($status) {
                if ($get_info->userid != 0) {
                    $client = Client::find($get_info->userid);
                    if ($client) {
                        $client->sms_limit -= 1;
                        $client->save();
                    }
                }
            }

        } else {
            $status = SMSHistory::create([
                'userid' => 0,
                'sender' => $number,
                'receiver' => $to,
                'message' => $body,
                'amount' => $msg_count,
                'status' => 'Success',
                'api_key' => null,
                'use_gateway' => $gateway,
                'send_by' => 'receiver',
                'sms_type' => 'text'
            ]);
        }

        if ($status) {
            return true;
        } else {
            return false;
        }


    }

    //======================================================================
    // replyTwilio Function Start Here
    //======================================================================
    public function replyTwilio(Request $request)
    {
        $number = $request->input('From');
        $to = $request->input('To');
        $body = $request->input('Body');

        if ($number == '' && $body == '' && $to == '') {
            return 'Invalid Request';
        }

        $clphone = str_replace(" ", "", $number); #Remove any whitespace
        $clphone = str_replace('+', '', $clphone);

        $msgcount = strlen(preg_replace('/\s+/', ' ', trim($body)));;
        $msgcount = $msgcount / 160;
        $msgcount = ceil($msgcount);

        $get_status = $this->insertSMS($clphone, $msgcount, $body, $to, 1);

        if ($get_status) {
            return 'success';
        } else {
            return 'failed';
        }

    }

    //======================================================================
    // replyTxtLocal Function Start Here
    //======================================================================
    public function replyTxtLocal(Request $request)
    {
        $number = $request->input('inNumber');
        $sender = $request->input('sender');
        $body = $request->input('content');


        if ($number == '' && $body == '') {
            return 'Invalid Request';
        }

        $msgcount = strlen(preg_replace('/\s+/', ' ', trim($body)));;
        $msgcount = $msgcount / 160;
        $msgcount = ceil($msgcount);

        $get_status = $this->insertSMS($number, $msgcount, $body, $sender, 4);

        if ($get_status) {
            return 'success';
        } else {
            return 'failed';
        }
    }


    //======================================================================
    // replySmsGlobal Function Start Here
    //======================================================================
    public function replySmsGlobal(Request $request)
    {
        $number = $request->input('to');
        $sender = $request->input('from');
        $body = $request->input('msg');


        if ($number == '' && $body == '') {
            return 'Invalid Request';
        }

        $msgcount = strlen(preg_replace('/\s+/', ' ', trim($body)));;
        $msgcount = $msgcount / 160;
        $msgcount = ceil($msgcount);

        $get_status = $this->insertSMS($number, $msgcount, $body, $sender, 8);

        if ($get_status) {
            return 'success';
        } else {
            return 'failed';
        }
    }


    //======================================================================
    // replyBulkSMS Function Start Here
    //======================================================================
    public function replyBulkSMS(Request $request)
    {
        $number = $request->input('msisdn');
        $sender = $request->input('sender');
        $body = $request->input('message');


        if ($number == '' && $body == '') {
            return 'Invalid Request';
        }

        $msgcount = strlen(preg_replace('/\s+/', ' ', trim($body)));;
        $msgcount = $msgcount / 160;
        $msgcount = ceil($msgcount);

        $get_status = $this->insertSMS($number, $msgcount, $body, $sender, 9);

        if ($get_status) {
            return 'success';
        } else {
            return 'failed';
        }
    }


    //======================================================================
    // replyNexmo Function Start Here
    //======================================================================
    public function replyNexmo(Request $request)
    {

        $number = $request->input('msisdn');
        $request = array_merge($_GET, $_POST);

// check that request is inbound message
        if (!isset($request['to']) OR !isset($request['msisdn']) OR !isset($request['text'])) {
            return;
        }

//Deal with concatenated messages
        $message = false;
        if (isset($request['concat']) AND $request['concat'] == true) {

            //generally this would be a database
            session_start();
            session_id($request['concat-ref']);

            if (!isset($_SESSION['messages'])) {
                $_SESSION['messages'] = array();
            }

            $_SESSION['messages'][] = $request;

            if (count($_SESSION['messages']) == $request['concat-total']) {
                //order messages
                usort(
                    $_SESSION['messages'], function ($a, $b) {
                    return $a['concat-part'] > $b['concat-part'];
                }
                );

                $message = array_reduce(
                    $_SESSION['messages'], function ($carry, $item) {
                    return $carry . $item['text'];
                }
                );
            }
        }

        $sender = $request['to'];
        $msgcount = strlen(preg_replace('/\s+/', ' ', trim($message)));;
        $msgcount = $msgcount / 160;
        $msgcount = ceil($msgcount);

        $get_status = $this->insertSMS($number, $msgcount, $message, $sender, 10);


        if ($get_status) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    //======================================================================
    // replyPlivo Function Start Here
    //======================================================================
    public function replyPlivo(Request $request)
    {
        $number = $request->input('From');
        $sender = $request->input('To');
        $message = $request->input('Text');

        $msgcount = strlen(preg_replace('/\s+/', ' ', trim($message)));;
        $msgcount = $msgcount / 160;
        $msgcount = ceil($msgcount);

        $get_status = $this->insertSMS($number, $msgcount, $message, $sender, 7);

        if ($get_status) {
            return 'success';
        } else {
            return 'failed';
        }
    }

    //======================================================================
    // deliveryReportBulkSMS Function Start Here
    //======================================================================
    public function deliveryReportBulkSMS(Request $request)
    {

        $batch = $request->input('batch_id');
        $status = $request->input('status');

        switch ($status) {
            case '11':
                $status = 'Success';
                break;

            case '22':
                $status = 'Internal fatal error';
                break;

            case '23':
                $status = 'Authentication failure';
                break;

            case '24':
                $status = 'Data validation failed';
                break;

            case '25':
                $status = 'You do not have sufficient credits';
                break;

            case '26':
                $status = 'Upstream credits not available';
                break;

            case '27':
                $status = 'You have exceeded your daily quota';
                break;

            case '28':
                $status = 'Upstream quota exceeded';
                break;

            case '29':
                $status = 'Message sending cancelled';
                break;

            case '31':
                $status = 'Unroutable';
                break;

            case '32':
                $status = 'Blocked';
                break;

            case '33':
                $status = 'Failed: censored';
                break;

            case '50':
                $status = 'Delivery failed - generic failure';
                break;

            case '51':
                $status = 'Delivery to phone failed';
                break;

            case '52':
                $status = 'Delivery to network failed';
                break;

            case '53':
                $status = 'Message expired';
                break;

            case '54':
                $status = 'Failed on remote network';
                break;

            case '55':
                $status = 'Failed: remotely blocked';
                break;

            case '56':
                $status = 'Failed: remotely censored';
                break;

            case '57':
                $status = 'Failed due to fault on handset';
                break;

            case '64':
                $status = 'Queued for retry after temporary failure delivering, due to fault on handset';
                break;

            case '70':
                $status = 'Unknown upstream status';
                break;

            case 'default':
                $status = 'Failed';
                break;

        }

        $existing_status = 'In progress|' . $batch;

        $get_data = SMSHistory::where('status', 'like', '%' . $existing_status . '%')->first();

        if ($get_data) {
            $get_data->status = $status;
            $get_data->save();

            return 'success';
        } else {
            return 'failed';
        }


    }

    //======================================================================
    // deliveryReportInfoBip Function Start Here
    //======================================================================
//    public function deliveryReportInfoBip(Request $request){
//
//
//        $gateway = SMSGateways::where('name','InfoBip')->first();
//
//        if ($gateway){
//            $api_key = base64_encode($gateway->username . ':' . $gateway->password);
//
//
//
//            $curl = curl_init();
//
//            $parametar = array(
//                CURLOPT_URL => "http://api.infobip.com/sms/1/reports",
//                CURLOPT_RETURNTRANSFER => true,
//                CURLOPT_ENCODING => "",
//                CURLOPT_MAXREDIRS => 10,
//                CURLOPT_TIMEOUT => 30,
//                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                CURLOPT_CUSTOMREQUEST => "GET",
//                CURLOPT_HTTPHEADER => array(
//                    "accept: application/json",
//                    "authorization: Basic $api_key"
//                ),
//            );
//
//
//            curl_setopt_array($curl, $parametar);
//
//            $response = curl_exec($curl);
//            $err = curl_error($curl);
//
//            curl_close($curl);
//
//            $get_data = json_decode($response, true);
//
//            echo "<pre>";
//            print_r($get_data);
//            echo "</pre>";
//            exit;
//
//
//            if (is_array($get_data)) {
//                if (array_key_exists('results', $get_data)) {
//                    foreach ($get_data['results'] as $msg) {
//                        if ($msg['status']['name'] == 'DELIVERED_TO_HANDSET'){
//                            $get_sms_status = $msg['messageId'];
//                        }else{
//                            $get_sms_status = $msg['status']['description'];
//                        }
//                    }
//                } elseif (array_key_exists('requestError', $get_data)) {
//                    foreach ($get_data['requestError'] as $msg) {
//                        $get_sms_status = $msg['text'];
//                    }
//                } else {
//                    $get_sms_status = 'Unknown error';
//                }
//            } else {
//                $get_sms_status = 'Unknown error';
//            }
//
//            if ($err) {
//                $get_sms_status = $err;
//            }
//
//        }
//
//
//
//        $existing_status = 'In progress|'.$batch;
//
//        $get_data = SMSHistory::where('status','like','%'.$existing_status.'%')->first();
//
//        if ($get_data){
//            $get_data->status=$status;
//            $get_data->save();
//
//            return 'success';
//        }else{
//            return 'failed';
//        }
//
//
//    }


    //======================================================================
    // replyMessageBird Function Start Here
    //======================================================================
    public function replyMessageBird(Request $request)
    {
        $number = $request->input('originator');
        $sender = $request->input('recipient');
        $body = $request->input('body');

        if ($number == '' && $body == '' && $sender) {
            return 'Invalid Request';
        }

        $clphone = str_replace(" ", "", $number); #Remove any whitespace
        $clphone = str_replace('+', '', $clphone);

        $msgcount = strlen(preg_replace('/\s+/', ' ', trim($body)));;
        $msgcount = $msgcount / 160;
        $msgcount = ceil($msgcount);

        $get_status = $this->insertSMS($clphone, $msgcount, $body, $sender, 42);

        if ($get_status) {
            return 'success';
        } else {
            return 'failed';
        }

    }

    //======================================================================
    // replyTropo Function Start Here
    //======================================================================
    public function replyTropo(Request $request)
    {

    }


}
