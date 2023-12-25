<?php

namespace App\Http\Controllers;

use App\BlackListContact;
use App\Classes\PhoneNumber;
use App\Client;
use App\ClientGroups;
use App\ContactList;
use App\CustomSMSGateways;
use App\ImportPhoneNumber;
use App\IntCountryCodes;
use App\Jobs\SendBulkSMS;
use App\PaymentGateways;
use App\ScheduleSMS;
use App\SenderIdManage;
use App\SMSBundles;
use App\SMSGateways;
use App\SMSHistory;
use App\SMSInbox;
use App\SMSPlanFeature;
use App\SMSPricePlan;
use App\SMSTemplates;
use App\StoreBulkSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class UserSMSController extends Controller
{
    public function __construct()
    {
        $this->middleware('client');
    }

    //======================================================================
    // senderIdManagement Function Start Here
    //======================================================================
    public function senderIdManagement()
    {

        $all_sender_id = SenderIdManage::where('status', 'unblock')->orWhere('status', 'Pending')->get();
        $all_ids = [];

        foreach ($all_sender_id as $sid) {
            $client_array = json_decode($sid->cl_id);

            if (is_array($client_array) && in_array('0', $client_array)) {
                array_push($all_ids, $sid->id);
            } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                array_push($all_ids, $sid->id);
            }
        }
        $sender_ids = array_unique($all_ids);

        $sender_id = SenderIdManage::whereIn('id', $sender_ids)->get();

        return view('client.sender-id-management', compact('sender_id'));
    }

    //======================================================================
    // postSenderID Function Start Here
    //======================================================================
    public function postSenderID(Request $request)
    {
        if ($request->sender_id == '') {
            return redirect('user/sms/sender-id-management')->with([
                'message' => language_data('Sender ID required'),
                'message_important' => true
            ]);
        }

        $client_id = (string)Auth::guard('client')->user()->id;
        $client_id = (array)$client_id;
        $client_id = json_encode($client_id);

        $sender_id = new  SenderIdManage();
        $sender_id->sender_id = $request->sender_id;
        $sender_id->cl_id = $client_id;
        $sender_id->status = 'pending';
        $sender_id->save();

        return redirect('user/sms/sender-id-management')->with([
            'message' => language_data('Request send successfully')
        ]);
    }


    //======================================================================
    // sendBulkSMS Function Start Here
    //======================================================================
    public function sendBulkSMS()
    {
        if (app_config('sender_id_verification') == '1') {
            $all_sender_id = SenderIdManage::where('status', 'unblock')->get();
            $all_ids = [];

            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (is_array($client_array) && in_array('0', $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $sender_ids = array_unique($all_ids);

        } else {
            $sender_ids = false;
        }

        $phone_book = ImportPhoneNumber::where('user_id', Auth::guard('client')->user()->id)->get();
        $client_group = ClientGroups::where('created_by', Auth::guard('client')->user()->id)->where('status', 'Yes')->get();
        $sms_templates = SMSTemplates::where('status', 'active')->where('cl_id', Auth::guard('client')->user()->id)->get();
        $schedule_sms = false;

        return view('client.send-bulk-sms', compact('client_group', 'sms_templates', 'sender_ids', 'phone_book', 'schedule_sms'));
    }

    //======================================================================
    // postSendBulkSMS Function Start Here
    //======================================================================
    public function postSendBulkSMS(Request $request)
    {

        if (function_exists('ini_set') && ini_get('max_execution_time')) {
            ini_set('max_execution_time', '-1');
        }

        if ($request->schedule_sms_status) {
            $v = \Validator::make($request->all(), [
                'message' => 'required', 'schedule_time' => 'required', 'message_type' => 'required', 'remove_duplicate' => 'required'
            ]);

            $redirect_url = 'user/sms/send-schedule-sms';
        } else {
            $v = \Validator::make($request->all(), [
                'message' => 'required', 'message_type' => 'required', 'remove_duplicate' => 'required'
            ]);

            $redirect_url = 'user/sms/send-sms';
        }

        if ($v->fails()) {
            return redirect($redirect_url)->withErrors($v->errors());
        }


        $client = Client::find(Auth::guard('client')->user()->id);
        $sms_count = $client->sms_limit;
        $sender_id = $request->sender_id;
        $msg_type = $request->message_type;

        if ($sender_id != '' && app_config('sender_id_verification') == '1') {
            $all_sender_id = SenderIdManage::all();
            $all_ids = [];

            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (is_array($client_array) && in_array('0', $client_array)) {
                    array_push($all_ids, $sender_id);
                } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $all_ids = array_unique($all_ids);

            if (!in_array($sender_id, $all_ids)) {
                return redirect($redirect_url)->with([
                    'message' => language_data('This Sender ID have Blocked By Administrator'),
                    'message_important' => true
                ]);
            }
        }

        $gateway = SMSGateways::find($client->sms_gateway);

        if ($gateway->status != 'Active') {
            return redirect($redirect_url)->with([
                'message' => language_data('SMS gateway not active.Contact with Provider'),
                'message_important' => true
            ]);
        }

        if ($gateway->custom == 'Yes') {
            $cg_info = CustomSMSGateways::where('gateway_id', $client->sms_gateway)->first();
        } else {
            $cg_info = '';
        }

        $message = $request->message;

        $get_cost = 0;
        $get_inactive_coverage = [];


        $results = [];
        $total_cost = 0;

        if ($request->contact_type == 'phone_book') {
            if (count($request->contact_list_id)) {
                $get_data = ContactList::whereIn('pid', $request->contact_list_id)->select('phone_number', 'email_address', 'user_name', 'company', 'first_name', 'last_name')->get()->toArray();
                foreach ($get_data as $data) {
                    array_push($results, $data);
                }
            }
        }

        if ($request->contact_type == 'client_group') {
            $get_group = Client::whereIn('groupid', $request->client_group_id)->select('phone AS phone_number', 'email AS email_address', 'username AS user_name', 'company AS company', 'fname AS first_name', 'lname AS last_name')->get()->toArray();
            foreach ($get_group as $data) {
                array_push($results, $data);
            }
        }

        if ($request->recipients) {
            $recipients = explode(',', $request->recipients);
            foreach ($recipients as $r) {
                $data = [
                    'phone_number' => trim($r),
                    'email_address' => null,
                    'user_name' => null,
                    'company' => null,
                    'first_name' => null,
                    'last_name' => null
                ];
                array_push($results, $data);
            }
        }


        if (is_array($results)) {

            if (count($results) > 0) {

                $filtered_data = [];
                $blacklist = BlackListContact::select('numbers')->get()->toArray();

                if ($blacklist && is_array($blacklist) && count($blacklist) > 0) {

                    $blacklist = array_column($blacklist, 'numbers');

                    array_filter($results, function ($element) use ($blacklist, &$filtered_data) {
                        if (!in_array($element['phone_number'], $blacklist)) {
                            array_push($filtered_data, $element);
                        }
                    });

                    $results = array_values($filtered_data);
                }

                if (count($results) <= 0) {
                    return redirect($redirect_url)->with([
                        'message' => 'Recipient empty',
                        'message_important' => true
                    ]);
                }

                if ($request->remove_duplicate == 'yes'){
                    $results = unique_multidim_array($results,'phone_number');
                }

                $results = array_values($results);

                foreach (array_chunk($results, 50) as $chunk_result) {
                    foreach ($chunk_result as $r) {
                        $msg_data = array(
                            'Phone Number' => $r['phone_number'],
                            'Email Address' => $r['email_address'],
                            'User Name' => $r['user_name'],
                            'Company' => $r['company'],
                            'First Name' => $r['first_name'],
                            'Last Name' => $r['last_name'],
                        );


                        $get_message = $this->renderSMS($message, $msg_data);

                        if ($msg_type != 'plain' && $msg_type != 'unicode') {
                            return redirect($redirect_url)->with([
                                'message' => 'Invalid message type',
                                'message_important' => true
                            ]);
                        }

                        if ($msg_type == 'plain') {
                            $msgcount = strlen(preg_replace('/\s+/', ' ', trim($get_message)));
                            if ($msgcount <= 160) {
                                $msgcount = 1;
                            } else {
                                $msgcount = $msgcount / 157;
                            }
                        }
                        if ($msg_type == 'unicode') {
                            $msgcount = mb_strlen(preg_replace('/\s+/', ' ', trim($get_message)),'UTF-8');

                            if ($msgcount <= 70) {
                                $msgcount = 1;
                            } else {
                                $msgcount = $msgcount / 67;
                            }
                        }
                        $msgcount = ceil($msgcount);

                        if ($gateway->name == 'FortDigital') {
                            $c_phone = 61;
                        } elseif ($gateway->name == 'Ibrbd') {
                            $c_phone = 880;
                        } else {
                            $phone = str_replace(['(', ')', '+', '-', ' '], '', $r['phone_number']);
                            $c_phone = PhoneNumber::get_code($phone);
                        }

                        $sms_cost = IntCountryCodes::where('country_code', $c_phone)->where('active', '1')->first();
                        if ($sms_cost) {
                            $sms_charge = $sms_cost->tariff;
                            $get_cost += $sms_charge;
                        } else {
                            array_push($get_inactive_coverage, 'found');
                        }


                        if (in_array('found', $get_inactive_coverage)) {
                            return redirect($redirect_url)->with([
                                'message' => language_data('Phone Number Coverage are not active'),
                                'message_important' => true
                            ]);
                        }

                        $total_cost = $get_cost * $msgcount;

                        if ($total_cost == 0) {
                            return redirect($redirect_url)->with([
                                'message' => language_data('You do not have enough sms balance'),
                                'message_important' => true
                            ]);
                        }

                        if ($total_cost > $sms_count) {
                            return redirect($redirect_url)->with([
                                'message' => language_data('You do not have enough sms balance'),
                                'message_important' => true
                            ]);
                        }
                    }
                }

                if ($request->send_later == 'on') {

                    if ($request->schedule_time == '') {
                        return redirect($redirect_url)->with([
                            'message' => 'Schedule time required',
                            'message_important' => true
                        ]);
                    }

                    $schedule_time = date('Y-m-d H:i:s', strtotime($request->schedule_time));

                    foreach (array_chunk($results, 50) as $chunk_result) {
                        foreach ($chunk_result as $r) {

                            $phone = str_replace(['(', ')', '+', '-', ' '], '', $r['phone_number']);

                            ScheduleSMS::create([
                                'userid' => Auth::guard('client')->user()->id,
                                'sender' => $sender_id,
                                'receiver' => $phone,
                                'amount' => $msgcount,
                                'message' => $get_message,
                                'type' => $msg_type,
                                'submit_time' => $schedule_time,
                                'use_gateway' => $gateway->id
                            ]);

                        }
                    }

                } else {

                    $final_insert_data = [];

                    foreach (array_chunk($results, 50) as $chunk_result) {
                        foreach ($chunk_result as $r) {
                            $msg_data = array(
                                'Phone Number' => $r['phone_number'],
                                'Email Address' => $r['email_address'],
                                'User Name' => $r['user_name'],
                                'Company' => $r['company'],
                                'First Name' => $r['first_name'],
                                'Last Name' => $r['last_name'],
                            );

                            $get_message = $this->renderSMS($message, $msg_data);

                            if ($msg_type == 'plain') {
                                $msgcount = strlen(preg_replace('/\s+/', ' ', trim($get_message)));
                                if ($msgcount <= 160) {
                                    $msgcount = 1;
                                } else {
                                    $msgcount = $msgcount / 157;
                                }
                            }
                            if ($msg_type == 'unicode') {
                                $msgcount = mb_strlen(preg_replace('/\s+/', ' ', trim($get_message)),'UTF-8');

                                if ($msgcount <= 70) {
                                    $msgcount = 1;
                                } else {
                                    $msgcount = $msgcount / 67;
                                }
                            }
                            $msgcount = ceil($msgcount);

                            $phone = str_replace(['(', ')', '+', '-', ' '], '', $r['phone_number']);

                            array_push($final_insert_data, [
                                'phone_number' => $phone,
                                'message' => $get_message,
                                'segments' => $msgcount
                            ]);
                        }
                    }

                    $final_data = json_encode($final_insert_data, true);

                    StoreBulkSMS::create([
                        'userid' => Auth::guard('client')->user()->id,
                        'sender' => $sender_id,
                        'msg_data' => $final_data,
                        'status' => 0,
                        'type' => $msg_type,
                        'use_gateway' => $gateway->id
                    ]);

                }


                $remain_sms = $sms_count - $total_cost;
                $client->sms_limit = $remain_sms;
                $client->save();

                return redirect($redirect_url)->with([
                    'message' => language_data('SMS added in queue and will deliver one by one')
                ]);


            } else {
                return redirect($redirect_url)->with([
                    'message' => 'Recipient empty',
                    'message_important' => true
                ]);
            }
        } else {
            return redirect($redirect_url)->with([
                'message' => 'Invalid Recipients',
                'message_important' => true
            ]);
        }

    }

    //======================================================================
    // purchaseSMSPlan Function Start Here
    //======================================================================
    public function purchaseSMSPlan()
    {
        $price_plan = SMSPricePlan::where('status', 'Active')->get();
        return view('client.sms-price-plan', compact('price_plan'));
    }

    //======================================================================
    // smsPlanFeature Function Start Here
    //======================================================================
    public function smsPlanFeature($id)
    {
        $sms_plan = SMSPricePlan::where('status', 'Active')->find($id);

        if ($sms_plan) {
            $plan_feature = SMSPlanFeature::where('pid', $id)->get();
            $payment_gateways = PaymentGateways::where('status', 'Active')->get();
            return view('client.sms-plan-feature', compact('sms_plan', 'plan_feature', 'payment_gateways'));
        } else {
            return redirect('user/sms/purchase-sms-plan')->with([
                'message' => language_data('SMS plan not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // sendSMSFromFile Function Start Here
    //======================================================================
    public function sendSMSFromFile()
    {
        if (app_config('sender_id_verification') == '1') {
            $all_sender_id = SenderIdManage::where('status', 'unblock')->get();
            $all_ids = [];


            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (is_array($client_array) && in_array('0', $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $sender_ids = array_unique($all_ids);

        } else {
            $sender_ids = false;
        }

        $sms_templates = SMSTemplates::where('status', 'active')->where('cl_id', Auth::guard('client')->user()->id)->get();
        $schedule_sms = false;

        return view('client.send-sms-file', compact('sms_templates', 'sender_ids', 'schedule_sms'));
    }

    //======================================================================
    // downloadSampleSMSFile Function Start Here
    //======================================================================
    public function downloadSampleSMSFile()
    {
        return response()->download('assets/test_file/sms.csv');
    }

    //======================================================================
    // postSMSFromFile Function Start Here
    //======================================================================
    public function postSMSFromFile(Request $request)
    {

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('user/sms/send-sms-file')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        if (function_exists('ini_set') && ini_get('max_execution_time')) {
            ini_set('max_execution_time', '-1');
        }


        if ($request->schedule_sms_status) {
            $v = \Validator::make($request->all(), [
                'import_numbers' => 'required', 'message' => 'required', 'schedule_time' => 'required', 'message_type' => 'required', 'remove_duplicate' => 'required'
            ]);

            $redirect_url = 'user/sms/send-schedule-sms-file';
        } else {
            $v = \Validator::make($request->all(), [
                'import_numbers' => 'required', 'message' => 'required', 'message_type' => 'required', 'remove_duplicate' => 'required'
            ]);

            $redirect_url = 'user/sms/send-sms-file';
        }


        if ($v->fails()) {
            return redirect($redirect_url)->withErrors($v->errors());
        }


        $client = Client::find(Auth::guard('client')->user()->id);
        $sms_count = $client->sms_limit;
        $sender_id = $request->sender_id;

        if ($sender_id != '' && app_config('sender_id_verification') == '1') {
            $all_sender_id = SenderIdManage::all();
            $all_ids = [];

            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (is_array($client_array) && in_array('0', $client_array)) {
                    array_push($all_ids, $sender_id);
                } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $all_ids = array_unique($all_ids);

            if (!in_array($sender_id, $all_ids)) {
                return redirect($redirect_url)->with([
                    'message' => language_data('This Sender ID have Blocked By Administrator'),
                    'message_important' => true
                ]);
            }
        }

        $gateway = SMSGateways::find($client->sms_gateway);

        if ($gateway->status != 'Active') {
            return redirect($redirect_url)->with([
                'message' => language_data('SMS gateway not active.Contact with Provider'),
                'message_important' => true
            ]);
        }

        if ($gateway->custom == 'Yes') {
            $cg_info = CustomSMSGateways::where('gateway_id', $client->sms_gateway)->first();
        } else {
            $cg_info = '';
        }

        $message = $request->message;
        $msg_type = $request->message_type;

        $file_extension = Input::file('import_numbers')->getClientOriginalExtension();

        $supportedExt = array('csv', 'xls', 'xlsx');

        if (!in_array_r($file_extension, $supportedExt)) {
            return redirect($redirect_url)->with([
                'message' => language_data('Insert Valid Excel or CSV file'),
                'message_important' => true
            ]);
        }

        $get_cost = 0;
        $get_inactive_coverage = [];
        $valid_phone_numbers = [];
        $get_data = [];
        $final_insert_data = [];

        $all_data = Excel::load($request->import_numbers)->noHeading()->all()->toArray();

        if ($all_data && is_array($all_data) && array_empty($all_data)) {
            return redirect($redirect_url)->with([
                'message' => 'Empty field',
                'message_important' => true
            ]);
        }

        $counter = "A";

        if ($request->header_exist == 'on') {

            $header = array_shift($all_data);

            foreach ($header as $key => $value) {
                if (!$value) {
                    $header[$key] = "Column " . $counter;
                }

                $counter++;
            }

        } else {

            $header_like = $all_data[0];

            $header = array();

            foreach ($header_like as $h) {
                array_push($header, "Column " . $counter);
                $counter++;
            }

        }

        $all_data = array_map(function ($row) use ($header) {

            return array_combine($header, $row);

        }, $all_data);

        $blacklist = BlackListContact::select('numbers')->get()->toArray();

        if ($blacklist && is_array($blacklist) && count($blacklist) > 0) {
            $blacklist = array_column($blacklist, 'numbers');
        }

        $number_column = $request->number_column;
        array_filter($all_data, function ($data) use ($number_column, &$get_data, &$valid_phone_numbers, $blacklist) {

            if ($data[$number_column]) {
                if (preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})[-\. ]?([0-9]{7})$/', trim($data[$number_column]))) {
                    if (!in_array($data[$number_column], $blacklist)) {
                        array_push($valid_phone_numbers, $data[$number_column]);
                        array_push($get_data, $data);
                    }
                }
            }
        });

        if (is_array($valid_phone_numbers) && count($valid_phone_numbers) <= 0) {
            return redirect($redirect_url)->with([
                'message' => 'Invalid phone numbers',
                'message_important' => true
            ]);
        }

        if (count($get_data) <= 0) {
            return redirect($redirect_url)->with([
                'message' => 'Recipient empty',
                'message_important' => true
            ]);
        }

        if ($request->remove_duplicate == 'yes'){
            $valid_phone_numbers = array_unique($valid_phone_numbers, SORT_REGULAR);
        }
        $valid_phone_numbers = array_values($valid_phone_numbers);

        foreach ($valid_phone_numbers as $c) {
            if ($gateway->name == 'FortDigital') {
                $c_phone = 61;
            } elseif ($gateway->name == 'Ibrbd') {
                $c_phone = 880;
            } else {
                $phone = str_replace(['(', ')', '+', '-', ' '], '', $c);
                $c_phone = PhoneNumber::get_code($phone);
            }

            $sms_cost = IntCountryCodes::where('country_code', $c_phone)->where('active', '1')->first();

            if ($sms_cost) {
                $sms_charge = $sms_cost->tariff;
                $get_cost += $sms_charge;
            } else {
                array_push($get_inactive_coverage, 'found');
            }
        }

        if (in_array('found', $get_inactive_coverage)) {
            return redirect($redirect_url)->with([
                'message' => language_data('Phone Number Coverage are not active'),
                'message_important' => true
            ]);
        }

        if ($msg_type != 'plain' && $msg_type != 'unicode') {
            return redirect($redirect_url)->with([
                'message' => 'Invalid message type',
                'message_important' => true
            ]);
        }

        if ($msg_type == 'plain') {
            $msgcount = strlen(preg_replace('/\s+/', ' ', trim($message)));
            if ($msgcount <= 160) {
                $msgcount = 1;
            } else {
                $msgcount = $msgcount / 157;
            }
        }
        if ($msg_type == 'unicode') {
            $msgcount = mb_strlen(preg_replace('/\s+/', ' ', trim($message)),'UTF-8');

            if ($msgcount <= 70) {
                $msgcount = 1;
            } else {
                $msgcount = $msgcount / 67;
            }
        }
        $msgcount = ceil($msgcount);


        $total_cost = $get_cost * $msgcount;

        if ($total_cost == 0) {
            return redirect($redirect_url)->with([
                'message' => language_data('You do not have enough sms balance'),
                'message_important' => true
            ]);
        }

        if ($total_cost > $sms_count) {
            return redirect($redirect_url)->with([
                'message' => language_data('You do not have enough sms balance'),
                'message_important' => true
            ]);
        }


        $message = $request->message;
        $sender_id = $request->sender_id;

        if ($request->remove_duplicate == 'yes'){
            $get_data = unique_multidim_array($get_data,$number_column);
        }
        $get_data = array_values($get_data);

        if ($request->send_later == 'on') {

            if ($request->schedule_time == '') {
                return redirect($redirect_url)->with([
                    'message' => 'Schedule time required',
                    'message_important' => true
                ]);
            }

            $schedule_time = date('Y-m-d H:i:s', strtotime($request->schedule_time));

            foreach ($get_data as $msg_data) {

                $get_message = $this->renderSMS($message, $msg_data);

                if ($msg_type == 'plain') {
                    $msgcount = strlen(preg_replace('/\s+/', ' ', trim($get_message)));
                    if ($msgcount <= 160) {
                        $msgcount = 1;
                    } else {
                        $msgcount = $msgcount / 157;
                    }
                }
                if ($msg_type == 'unicode') {
                    $msgcount = mb_strlen(preg_replace('/\s+/', ' ', trim($get_message)),'UTF-8');

                    if ($msgcount <= 70) {
                        $msgcount = 1;
                    } else {
                        $msgcount = $msgcount / 67;
                    }
                }

                $msgcount = ceil($msgcount);

                $clphone = str_replace(['(', ')', '+', '-', ' '], '', $msg_data[$number_column]);

                ScheduleSMS::create([
                    'userid' => Auth::guard('client')->user()->id,
                    'sender' => $sender_id,
                    'receiver' => $clphone,
                    'amount' => $msgcount,
                    'message' => $get_message,
                    'type' => $msg_type,
                    'submit_time' => $schedule_time,
                    'use_gateway' => $gateway->id
                ]);

            }

        } else {
            foreach ($get_data as $msg_data) {

                $get_message = $this->renderSMS($message, $msg_data);

                if ($msg_type == 'plain') {
                    $msgcount = strlen(preg_replace('/\s+/', ' ', trim($get_message)));
                    if ($msgcount <= 160) {
                        $msgcount = 1;
                    } else {
                        $msgcount = $msgcount / 157;
                    }
                }
                if ($msg_type == 'unicode') {
                    $msgcount = mb_strlen(preg_replace('/\s+/', ' ', trim($get_message)),'UTF-8');

                    if ($msgcount <= 70) {
                        $msgcount = 1;
                    } else {
                        $msgcount = $msgcount / 67;
                    }
                }

                $msgcount = ceil($msgcount);

                $clphone = str_replace(['(', ')', '+', '-', ' '], '', $msg_data[$number_column]);
                array_push($final_insert_data, [
                    'phone_number' => $clphone,
                    'message' => $get_message,
                    'segments' => $msgcount
                ]);

            }

            $results = json_encode($final_insert_data, true);


            StoreBulkSMS::create([
                'userid' => Auth::guard('client')->user()->id,
                'sender' => $sender_id,
                'msg_data' => $results,
                'status' => 0,
                'type' => $msg_type,
                'use_gateway' => $gateway->id
            ]);
        }


        $remain_sms = $sms_count - $total_cost;
        $client->sms_limit = $remain_sms;
        $client->save();


        return redirect($redirect_url)->with([
            'message' => language_data('SMS added in queue and will deliver one by one')
        ]);

    }


    //======================================================================
    // sendScheduleSMS Function Start Here
    //======================================================================
    public function sendScheduleSMS()
    {
        if (app_config('sender_id_verification') == '1') {
            $all_sender_id = SenderIdManage::where('status', 'unblock')->get();
            $all_ids = [];

            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (is_array($client_array) && in_array('0', $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $sender_ids = array_unique($all_ids);

        } else {
            $sender_ids = false;
        }

        $phone_book = ImportPhoneNumber::where('user_id', Auth::guard('client')->user()->id)->get();
        $client_group = ClientGroups::where('created_by', Auth::guard('client')->user()->id)->where('status', 'Yes')->get();
        $sms_templates = SMSTemplates::where('status', 'active')->where('cl_id', Auth::guard('client')->user()->id)->get();
        $schedule_sms = true;

        return view('client.send-bulk-sms', compact('client_group', 'sms_templates', 'sender_ids', 'phone_book', 'schedule_sms'));
    }


    //======================================================================
    // sendScheduleSMSFromFile Function Start Here
    //======================================================================
    public function sendScheduleSMSFromFile()
    {
        if (app_config('sender_id_verification') == '1') {
            $all_sender_id = SenderIdManage::where('status', 'unblock')->get();
            $all_ids = [];


            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (is_array($client_array) && in_array('0', $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $sender_ids = array_unique($all_ids);

        } else {
            $sender_ids = false;
        }

        $gateways = SMSGateways::where('status', 'Active')->where('schedule', 'Yes')->find(Auth::guard('client')->user()->sms_gateway);
        $sms_templates = SMSTemplates::where('status', 'active')->where('cl_id', Auth::guard('client')->user()->id)->get();

        if ($gateways == '') {
            return redirect('dashboard')->with([
                'message' => language_data('Schedule feature not supported'),
            ]);
        }

        $schedule_sms = true;

        return view('client.send-sms-file', compact('sms_templates', 'sender_ids', 'schedule_sms'));
    }

    //======================================================================
    // smsHistory Function Start Here
    //======================================================================
    public function smsHistory()
    {
        return view('client.sms-history');
    }


    //======================================================================
    // smsViewInbox Function Start Here
    //======================================================================
    public function smsViewInbox($id)
    {

        $inbox_info = SMSHistory::where('userid', Auth::guard('client')->user()->id)->find($id);

        if ($inbox_info) {
            return view('client.sms-inbox', compact('inbox_info'));
        } else {
            return redirect('user/sms/history')->with([
                'message' => language_data('SMS Not Found'),
                'message_important' => true
            ]);
        }

    }


    //======================================================================
    // deleteSMS Function Start Here
    //======================================================================
    public function deleteSMS($id)
    {

        $inbox_info = SMSHistory::where('userid', Auth::guard('client')->user()->id)->find($id);

        if ($inbox_info) {
            $inbox_info->delete();

            return redirect('user/sms/history')->with([
                'message' => language_data('SMS info deleted successfully')
            ]);
        } else {
            return redirect('sms/history')->with([
                'message' => language_data('SMS Not Found'),
                'message_important' => true
            ]);
        }

    }



    //======================================================================
    // apiInfo Function Start Here
    //======================================================================
    public function apiInfo()
    {
        return view('client.sms-api-info');
    }

    //======================================================================
    // updateApiInfo Function Start Here
    //======================================================================
    public function updateApiInfo(Request $request)
    {

        $v = \Validator::make($request->all(), [
            'api_key' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/sms-api/info')->withErrors($v->errors());
        }

        if ($request->api_key != '') {
            Client::where('id', Auth::guard('client')->user()->id)->where('api_access', 'Yes')->update(['api_key' => $request->api_key]);
        }


        return redirect('user/sms-api/info')->with([
            'message' => language_data('API information updated successfully')
        ]);

    }


    /*Version 1.1*/


    //======================================================================
    // updateScheduleSMS Function Start Here
    //======================================================================
    public function updateScheduleSMS()
    {
        $sms_history = ScheduleSMS::where('userid', Auth::guard('client')->user()->id)->get();
        return view('client.update-schedule-sms', compact('sms_history'));
    }



    //======================================================================
    // manageUpdateScheduleSMS Function Start Here
    //======================================================================
    public function manageUpdateScheduleSMS($id)
    {
        $sh = ScheduleSMS::find($id);

        if ($sh) {

            if (app_config('sender_id_verification') == '1') {
                $all_sender_id = SenderIdManage::where('status', 'unblock')->get();
                $all_ids = [];


                foreach ($all_sender_id as $sid) {
                    $client_array = json_decode($sid->cl_id);

                    if (is_array($client_array) && in_array('0', $client_array)) {
                        array_push($all_ids, $sid->sender_id);
                    } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                        array_push($all_ids, $sid->sender_id);
                    }
                }
                $sender_ids = array_unique($all_ids);

            } else {
                $sender_ids = false;
            }

            return view('client.manage-update-schedule-sms', compact('sh', 'sender_ids'));
        } else {
            return redirect('user/sms/update-schedule-sms')->with([
                'message' => language_data('Please try again'),
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // postUpdateScheduleSMS Function Start Here
    //======================================================================
    public function postUpdateScheduleSMS(Request $request)
    {

        $cmd = $request->cmd;

        $v = \Validator::make($request->all(), [
            'phone_number' => 'required', 'message' => 'required', 'schedule_time' => 'required', 'message_type' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/sms/manage-update-schedule-sms/' . $cmd)->withErrors($v->errors());
        }


        $blacklist = BlackListContact::select('numbers')->get()->toArray();

        if ($blacklist && is_array($blacklist) && count($blacklist) > 0) {
            $blacklist = array_column($blacklist, 'numbers');
        }

        if (in_array($request->phone_number, $blacklist)) {
            return redirect('user/sms/manage-update-schedule-sms/' . $cmd)->with([
                'message' => 'Phone number contain in blacklist',
                'message_important' => true
            ]);
        }


        $client = Client::find(Auth::guard('client')->user()->id);

        if ($client == '') {
            return redirect('user/sms/manage-update-schedule-sms/' . $cmd)->with([
                'message' => language_data('Client info not found'),
                'message_important' => true
            ]);
        }

        $gateway = SMSGateways::find($client->sms_gateway);
        if ($gateway->status != 'Active') {
            return redirect('user/sms/manage-update-schedule-sms/' . $cmd)->with([
                'message' => language_data('SMS gateway not active.Contact with Provider'),
                'message_important' => true
            ]);
        }

        if ($gateway->custom == 'Yes') {
            $cg_info = CustomSMSGateways::where('gateway_id', $client->sms_gateway)->first();
        } else {
            $cg_info = '';
        }

        $message = $request->message;
        $msg_type = $request->message_type;

        if ($msg_type != 'plain' && $msg_type != 'unicode') {
            return redirect('user/sms/manage-update-schedule-sms/' . $cmd)->with([
                'message' => 'Invalid message type',
                'message_important' => true
            ]);
        }

        if ($msg_type == 'plain') {
            $msgcount = strlen(preg_replace('/\s+/', ' ', trim($message)));
            if ($msgcount <= 160) {
                $msgcount = 1;
            } else {
                $msgcount = $msgcount / 157;
            }
        }
        if ($msg_type == 'unicode') {
            $msgcount = mb_strlen(preg_replace('/\s+/', ' ', trim($message)),'UTF-8');

            if ($msgcount <= 70) {
                $msgcount = 1;
            } else {
                $msgcount = $msgcount / 67;
            }
        }

        $msgcount = ceil($msgcount);

        $sender_id = $request->sender_id;

        if ($gateway->name == 'FortDigital') {
            $c_phone = 61;
        } elseif ($gateway->name == 'Ibrbd') {
            $c_phone = 880;
        } else {
            $phone = str_replace(['(', ')', '+', '-', ' '], '', $request->phone_number);
            $c_phone = PhoneNumber::get_code($phone);
        }

        $sms_info = ScheduleSMS::find($cmd);

        $sms_cost = IntCountryCodes::where('country_code', $c_phone)->where('active', '1')->first();

        if ($sms_cost) {
            $total_cost = ($sms_cost->tariff * $msgcount);
            if ($total_cost == 0) {
                return redirect('user/sms/manage-update-schedule-sms/' . $cmd)->with([
                    'message' => language_data('You do not have enough sms balance'),
                    'message_important' => true
                ]);
            }

            $total_cost -= $sms_info->amount;

            if ($total_cost > $client->sms_limit) {
                return redirect('user/sms/manage-update-schedule-sms/' . $cmd)->with([
                    'message' => language_data('You do not have enough sms balance'),
                    'message_important' => true
                ]);
            }
        } else {
            return redirect('user/sms/manage-update-schedule-sms/' . $cmd)->with([
                'message' => language_data('Phone Number Coverage are not active'),
                'message_important' => true
            ]);
        }


        if ($sender_id != '' && app_config('sender_id_verification') == '1') {
            $all_sender_id = SenderIdManage::all();
            $all_ids = [];

            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (is_array($client_array) && in_array('0', $client_array)) {
                    array_push($all_ids, $sender_id);
                } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $all_ids = array_unique($all_ids);

            if (!in_array($sender_id, $all_ids)) {
                return redirect('user/sms/manage-update-schedule-sms/' . $cmd)->with([
                    'message' => language_data('This Sender ID have Blocked By Administrator'),
                    'message_important' => true
                ]);
            }
        }

        $schedule_time = date('Y-m-d H:i:s', strtotime($request->schedule_time));

        ScheduleSMS::where('id', $request->cmd)->update([
            'sender' => $sender_id,
            'receiver' => $request->phone_number,
            'amount' => $msgcount,
            'message' => $message,
            'type' => $msg_type,
            'submit_time' => $schedule_time,
        ]);

        $remain_sms = $client->sms_limit - $total_cost;
        $client->sms_limit = $remain_sms;
        $client->save();

        return redirect('user/sms/update-schedule-sms')->with([
            'message' => language_data('SMS are scheduled. Deliver in correct time')
        ]);

    }

    //======================================================================
    // deleteScheduleSMS Function Start Here
    //======================================================================
    public function deleteScheduleSMS($id)
    {

        $sh = ScheduleSMS::find($id);
        if ($sh) {
            $client = Client::find($sh->userid);
            $client->sms_limit += $sh->amount;
            $client->save();

            $sh->delete();
            return redirect('user/sms/update-schedule-sms')->with([
                'message' => language_data('SMS info deleted successfully')
            ]);
        } else {
            return redirect('user/sms/update-schedule-sms')->with([
                'message' => language_data('Please try again'),
                'message_important' => true
            ]);
        }
    }


    /*Verson 1.2*/

    //======================================================================
    // buyUnit Function Start Here
    //======================================================================
    public function buyUnit()
    {
        $bundles = SMSBundles::orderBy('unit_from')->get();
        $payment_gateways = PaymentGateways::where('status', 'Active')->get();
        return view('client.buy-unit', compact('bundles', 'payment_gateways'));
    }

    //======================================================================
    // getTransaction Function Start Here
    //======================================================================
    public function getTransaction(Request $request)
    {


        if ($request->unit_number != '') {
            $data = DB::select("select * from `sys_sms_bundles` where (`unit_from` <= $request->unit_number and `unit_to` >= $request->unit_number) LIMIT 1");
            $data_count = count($data);

            if ($data_count != 0) {
                $unit_price = $data[0]->price;
                $amount_to_pay = $request->unit_number * $unit_price;
                $transaction_fee = ($amount_to_pay * $data[0]->trans_fee) / 100;
                $total = $amount_to_pay + $transaction_fee;
            } else {
                $unit_price = 'Price Bundle empty';
                $amount_to_pay = 'Price Bundle empty';
                $transaction_fee = 'Price Bundle empty';
                $total = 'Price Bundle empty';
            }
        } else {
            $unit_price = 'Price Bundle empty';
            $amount_to_pay = 'Price Bundle empty';
            $transaction_fee = 'Price Bundle empty';
            $total = 'Price Bundle empty';
        }


        return response()->json([
            'unit_price' => $unit_price,
            'amount_to_pay' => $amount_to_pay,
            'transaction_fee' => $transaction_fee,
            'total' => $total
        ]);


    }

    //======================================================================
    // postGetTemplateInfo Function Start Here
    //======================================================================
    public function postGetTemplateInfo(Request $request)
    {
        $template = SMSTemplates::find($request->st_id);
        if ($template) {
            return response()->json([
                'from' => $template->from,
                'message' => $template->message,
            ]);
        }
    }

    //======================================================================
    // renderSMS Start Here
    //======================================================================
    public function renderSMS($msg, $data)
    {
        preg_match_all('~<%(.*?)%>~s', $msg, $datas);
        $Html = $msg;
        foreach ($datas[1] as $value) {
            if (array_key_exists($value, $data)) {
                $Html = str_replace($value, $data[$value], $Html);
            } else {
                $Html = str_replace($value, '', $Html);
            }
        }
        return str_replace(array("<%", "%>"), '', $Html);
    }


    //======================================================================
    // smsTemplates Function Start Here
    //======================================================================
    public function smsTemplates()
    {
        $sms_templates = SMSTemplates::where('cl_id', Auth::guard('client')->user()->id)->orWhere('global', 'yes')->get();
        return view('client.sms-templates', compact('sms_templates'));
    }

    //======================================================================
    // createSmsTemplate Function Start Here
    //======================================================================
    public function createSmsTemplate()
    {
        if (app_config('sender_id_verification') == '1') {
            $all_sender_id = SenderIdManage::where('status', 'unblock')->get();
            $all_ids = [];


            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (in_array('0', $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                } elseif (in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $sender_ids = array_unique($all_ids);

        } else {
            $sender_ids = false;
        }

        return view('client.create-sms-template', compact('sender_ids'));
    }

    //======================================================================
    // postSmsTemplate Function Start Here
    //======================================================================
    public function postSmsTemplate(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'template_name' => 'required', 'message' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/sms/create-sms-template')->withErrors($v->errors());
        }
        $exist = SMSTemplates::where('template_name', $request->template_name)->where('cl_id', Auth::guard('client')->user()->id)->first();

        if ($exist) {
            return redirect('user/sms/create-sms-template')->with([
                'message' => language_data('Template already exist'),
                'message_important' => true
            ]);
        }

        $st = new SMSTemplates();
        $st->cl_id = Auth::guard('client')->user()->id;
        $st->template_name = $request->template_name;
        $st->from = $request->from;
        $st->message = $request->message;
        $st->global = 'no';
        $st->status = 'active';
        $st->save();

        return redirect('user/sms/sms-templates')->with([
            'message' => language_data('Sms template created successfully')
        ]);

    }

    //======================================================================
    // manageSmsTemplate Function Start Here
    //======================================================================
    public function manageSmsTemplate($id)
    {

        $st = SMSTemplates::find($id);
        if ($st) {

            if (app_config('sender_id_verification') == '1') {
                $all_sender_id = SenderIdManage::where('status', 'unblock')->get();
                $all_ids = [];

                foreach ($all_sender_id as $sid) {
                    $client_array = json_decode($sid->cl_id);

                    if (in_array('0', $client_array)) {
                        array_push($all_ids, $sid->sender_id);
                    } elseif (in_array(Auth::guard('client')->user()->id, $client_array)) {
                        array_push($all_ids, $sid->sender_id);
                    }
                }
                $sender_ids = array_unique($all_ids);

            } else {
                $sender_ids = false;
            }

            return view('client.manage-sms-template', compact('st', 'sender_ids'));
        } else {
            return redirect('user/sms/sms-templates')->with([
                'message' => language_data('Sms template not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // postManageSmsTemplate Function Start Here
    //======================================================================
    public function postManageSmsTemplate(Request $request)
    {
        $cmd = Input::get('cmd');
        $v = \Validator::make($request->all(), [
            'template_name' => 'required', 'message' => 'required', 'status' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/sms/manage-sms-template/' . $cmd)->withErrors($v->errors());
        }

        $st = SMSTemplates::find($cmd);

        if ($st) {
            if ($st->template_name != $request->template_name) {

                $exist = SMSTemplates::where('template_name', $request->template_name)->where('cl_id', Auth::guard('client')->user()->id)->first();

                if ($exist) {
                    return redirect('user/sms/manage-sms-template/' . $cmd)->with([
                        'message' => language_data('Template already exist'),
                        'message_important' => true
                    ]);
                }
            }

            $st->template_name = $request->template_name;
            $st->from = $request->from;
            $st->message = $request->message;
            $st->status = $request->status;
            $st->save();

            return redirect('user/sms/sms-templates')->with([
                'message' => language_data('Sms template updated successfully')
            ]);

        } else {
            return redirect('user/sms/sms-templates')->with([
                'message' => language_data('Sms template not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // deleteSmsTemplate Function Start Here
    //======================================================================
    public function deleteSmsTemplate($id)
    {
        $st = SMSTemplates::find($id);
        if ($st) {
            $st->delete();

            return redirect('user/sms/sms-templates')->with([
                'message' => language_data('Sms template delete successfully')
            ]);

        } else {
            return redirect('user/sms/sms-templates')->with([
                'message' => language_data('Sms template not found'),
                'message_important' => true
            ]);
        }
    }



    /*Version 2.0*/

    //======================================================================
    // blacklistContacts Function Start Here
    //======================================================================
    public function blacklistContacts()
    {
        return view('client.blacklist-contacts');
    }

    //======================================================================
    // postBlacklistContact Function Start Here
    //======================================================================
    public function postBlacklistContact(Request $request)
    {

        $v = \Validator::make($request->all(), [
            'phone_number' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/sms/blacklist-contacts')->withErrors($v->errors());
        }


        $number = str_replace(['(', ')', '+', '-', ' '], '', $request->phone_number);

        $exist = BlackListContact::where('numbers', $number)->where('user_id', Auth::guard('client')->user()->id)->first();

        if ($exist) {
            return redirect('user/sms/blacklist-contacts')->with([
                'message' => 'Contact already exist',
                'message_important' => true
            ]);
        }

        BlackListContact::create([
            'user_id' => Auth::guard('client')->user()->id,
            'numbers' => $number
        ]);

        return redirect('user/sms/blacklist-contacts')->with([
            'message' => 'Number added on blacklist',
        ]);

    }

    //======================================================================
    // deleteBlacklistContact Function Start Here
    //======================================================================
    public function deleteBlacklistContact($id)
    {
        $blacklist = BlackListContact::where('user_id', Auth::guard('client')->user()->id)->find($id);
        if ($blacklist) {
            $blacklist->delete();
            return redirect('user/sms/blacklist-contacts')->with([
                'message' => 'Number deleted from blacklist',
            ]);
        } else {
            return redirect('user/sms/blacklist-contacts')->with([
                'message' => 'Number not found on blacklist',
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // getBlacklistContacts Function Start Here
    //======================================================================
    public function getBlacklistContacts()
    {
        $blacklist = BlackListContact::select(['id', 'numbers'])->where('user_id', Auth::guard('client')->user()->id)->get();
        return Datatables::of($blacklist)
            ->addColumn('action', function ($bl) {
                return '
            <a href="#" class="btn btn-danger btn-xs cdelete" id="' . $bl->id . '"><i class="fa fa-trash"></i> ' . language_data("Delete") . '</a>';
            })
            ->escapeColumns([])
            ->make(true);
    }


    //======================================================================
    // getSmsHistoryData Function Start Here
    //======================================================================
    public function getSmsHistoryData(Request $request)
    {
        if ($request->has('order') && $request->has('columns')) {
            $order_col_num = $request->get('order')[0]['column'];
            $get_search_column = $request->get('columns')[$order_col_num]['name'];
            $short_by = $request->get('order')[0]['dir'];

            if ($get_search_column == 'date'){
                $get_search_column = 'updated_at';
            }

        } else {
            $get_search_column = 'updated_at';
            $short_by = 'DESC';
        }

        $sms_history = SMSHistory::select(['id', 'sender', 'receiver', 'amount', 'status', 'send_by', 'updated_at', 'api_key'])->where('userid', Auth::guard('client')->user()->id)->orderBy($get_search_column, $short_by);

        return Datatables::of($sms_history)
            ->addColumn('action', function ($sms) {
                return '
                <a class="btn btn-success btn-xs" href="' . url("user/sms/view-inbox/$sms->id") . '" ><i class="fa fa-inbox"></i> ' . language_data('Inbox') . '</a>
                <a href="#" id="' . $sms->id . '" class="cdelete btn btn-xs btn-danger"><i class="fa fa-danger"></i> ' . language_data('Delete') . '</a>
                ';
            })
            ->addColumn('date', function ($sms) {
                return $sms->updated_at;
            })
            ->addColumn('id', function ($sms) {
                return "<div class='coder-checkbox'>
                             <input type='checkbox'  class='deleteRow' value='$sms->id'  />
                                            <span class='co-check-ui'></span>
                                        </div>";

            })
            ->filter(function ($query) use ($request) {

                if ($request->has('send_by') && $request->get('send_by') != '0') {
                    $query->where('send_by', $request->get('send_by'));
                }

                if ($request->has('sender')) {
                    $query->where('sender', 'like', "%{$request->get('sender')}%");
                }

                if ($request->has('receiver')) {
                    $query->where('receiver', 'like', "%{$request->get('receiver')}%");
                }

                if ($request->has('status')) {
                    $query->where('status', 'like', "%{$request->get('status')}%");
                }

                if ($request->has('date_from') && $request->has('date_to')) {
                    $date_from = date('Y-m-d H:i:s', strtotime($request->get('date_from')));
                    $date_to = date('Y-m-d H:i:s', strtotime($request->get('date_to')));
                    $query->whereBetween('updated_at', [$date_from, $date_to]);
                }
            })
            ->addColumn('send_by', function ($sms) {
                if ($sms->send_by == 'sender') {
                    return language_data('Outgoing');
                } elseif ($sms->send_by == 'api') {
                    return '<span class="text-success"> API SMS</span>';
                } else {
                    return '<span class="text-success"> ' . language_data('Incoming') . ' </span>';
                }
            })
            ->escapeColumns([])
            ->make(true);
    }

    //======================================================================
    // getRecipientsData Function Start Here
    //======================================================================
    public function getRecipientsData(Request $request)
    {
        if ($request->has('client_group_ids')) {
            $client_group_ids = $request->client_group_ids;
            if (is_array($client_group_ids) && count($client_group_ids) > 0) {
                $count = Client::whereIn('groupid', $client_group_ids)->count();
                return response()->json(['status' => 'success', 'data' => $count]);
            } else {
                return response()->json(['status' => 'success', 'data' => 0]);
            }
        } elseif ($request->has('contact_list_ids')) {
            $contact_list_ids = $request->contact_list_ids;
            if (is_array($contact_list_ids) && count($contact_list_ids) > 0) {
                $count = ContactList::whereIn('pid', $contact_list_ids)->count();
                return response()->json(['status' => 'success', 'data' => $count]);
            } else {
                return response()->json(['status' => 'success', 'data' => 0]);
            }
        } else {
            return response()->json(['status' => 'success', 'data' => 0]);
        }
    }

    //======================================================================
    // deleteBulkSMS Function Start Here
    //======================================================================
    public function deleteBulkSMS(Request $request)
    {
        if ($request->has('data_ids')) {
            $all_ids = explode(',', $request->get('data_ids'));

            if (is_array($all_ids) && count($all_ids) > 0) {
                SMSHistory::where('userid', Auth::guard('client')->user()->id)->whereIn('id', $all_ids)->delete();
            }
        }
    }


    //======================================================================
    // sdkInfo Function Start Here
    //======================================================================
    public function sdkInfo()
    {
        return view('client.sms-sdk-info');
    }


    //======================================================================
    // sendQuickSMS Function Start Here
    //======================================================================
    public function sendQuickSMS()
    {
        if (app_config('sender_id_verification') == '1') {
            $all_sender_id = SenderIdManage::where('status', 'unblock')->get();
            $all_ids = [];

            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (is_array($client_array) && in_array('0', $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $sender_ids = array_unique($all_ids);

        } else {
            $sender_ids = false;
        }

        return view('client.send-quick-sms', compact('sender_ids'));
    }




    //======================================================================
    // postQuickSMS Function Start Here
    //======================================================================
    public function postQuickSMS(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'recipients' => 'required', 'message' => 'required', 'message_type' => 'required', 'remove_duplicate' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/sms/quick-sms')->withErrors($v->errors());
        }

        $client = Client::find(Auth::guard('client')->user()->id);
        $sms_count = $client->sms_limit;
        $sender_id = $request->sender_id;

        if ($sender_id != '' && app_config('sender_id_verification') == '1') {
            $all_sender_id = SenderIdManage::all();
            $all_ids = [];

            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (is_array($client_array) && in_array('0', $client_array)) {
                    array_push($all_ids, $sender_id);
                } elseif (is_array($client_array) && in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $all_ids = array_unique($all_ids);

            if (!in_array($sender_id, $all_ids)) {
                return redirect('user/sms/quick-sms')->with([
                    'message' => language_data('This Sender ID have Blocked By Administrator'),
                    'message_important' => true
                ]);
            }
        }

        try {

            $recipients = explode(',', $request->recipients);
            $results = array_filter($recipients);

            if (is_array($results) && count($results) <= 100) {

                $gateway = SMSGateways::find($client->sms_gateway);
                if ($gateway->status != 'Active') {
                    return redirect('user/sms/quick-sms')->with([
                        'message' => language_data('SMS gateway not active'),
                        'message_important' => true
                    ]);
                }

                if ($gateway->custom == 'Yes') {
                    $cg_info = CustomSMSGateways::where('gateway_id', $client->sms_gateway)->first();
                } else {
                    $cg_info = '';
                }

                $message = $request->message;
                $msg_type = $request->message_type;

                if ($msg_type != 'plain' && $msg_type != 'unicode') {
                    return redirect('user/sms/quick-sms')->with([
                        'message' => 'Invalid message type',
                        'message_important' => true
                    ]);
                }

                if ($msg_type == 'plain') {
                    $msgcount = strlen(preg_replace('/\s+/', ' ', trim($message)));
                    if ($msgcount <= 160) {
                        $msgcount = 1;
                    } else {
                        $msgcount = $msgcount / 157;
                    }
                }
                if ($msg_type == 'unicode') {
                    $msgcount = mb_strlen(preg_replace('/\s+/', ' ', trim($message)),'UTF-8');

                    if ($msgcount <= 70) {
                        $msgcount = 1;
                    } else {
                        $msgcount = $msgcount / 67;
                    }
                }

                $msgcount = ceil($msgcount);


                $get_cost = 0;
                $get_inactive_coverage = [];
                $total_cost = 0;

                $filtered_data = [];
                $blacklist = BlackListContact::select('numbers')->get()->toArray();

                if ($blacklist && is_array($blacklist) && count($blacklist) > 0) {

                    $blacklist = array_column($blacklist, 'numbers');

                    array_filter($results, function ($element) use ($blacklist, &$filtered_data) {
                        if (!in_array(trim($element), $blacklist)) {
                            array_push($filtered_data, $element);
                        }
                    });

                    $results = array_values($filtered_data);
                }


                if (count($results) <= 0) {
                    return redirect('user/sms/quick-sms')->with([
                        'message' => 'Recipient empty',
                        'message_important' => true
                    ]);
                }

                if ($request->remove_duplicate == 'yes'){
                    $results = array_unique($results, SORT_REGULAR);
                }

                $results = array_values($results);

                foreach ($results as $r) {

                    if ($gateway->name == 'FortDigital') {
                        $c_phone = 61;
                    } elseif ($gateway->name == 'Ibrbd') {
                        $c_phone = 880;
                    } else {
                        $phone = str_replace(['(', ')', '+', '-', ' '], '', trim($r));
                        $c_phone = PhoneNumber::get_code($phone);
                    }

                    $sms_cost = IntCountryCodes::where('country_code', $c_phone)->where('active', '1')->first();
                    if ($sms_cost) {
                        $sms_charge = $sms_cost->tariff;
                        $get_cost += $sms_charge;
                    } else {
                        array_push($get_inactive_coverage, 'found');
                    }


                    if (in_array('found', $get_inactive_coverage)) {
                        return redirect('user/sms/quick-sms')->with([
                            'message' => language_data('Phone Number Coverage are not active'),
                            'message_important' => true
                        ]);
                    }

                    $total_cost = $get_cost * $msgcount;

                    if ($total_cost == 0) {
                        return redirect('user/sms/quick-sms')->with([
                            'message' => language_data('You do not have enough sms balance'),
                            'message_important' => true
                        ]);
                    }

                    if ($total_cost > $sms_count) {
                        return redirect('user/sms/quick-sms')->with([
                            'message' => language_data('You do not have enough sms balance'),
                            'message_important' => true
                        ]);
                    }
                }

                foreach ($results as $r) {
                    $phone = str_replace(['(', ')', '+', '-', ' '], '', trim($r));
                    $this->dispatch(new SendBulkSMS($client->id, $phone, $gateway, $sender_id, $message, $msgcount, $cg_info,'',$msg_type));
                }

                $remain_sms = $sms_count - $total_cost;
                $client->sms_limit = $remain_sms;
                $client->save();


                return redirect('user/sms/quick-sms')->with([
                    'message' => 'Please check sms history for status'
                ]);
            } else {
                return redirect('user/sms/quick-sms')->with([
                    'message' => 'You can not send more than 100 sms using quick sms option',
                    'message_important' => true
                ]);
            }

        } catch (\Exception $e) {
            return redirect('user/sms/quick-sms')->with([
                'message' => $e->getMessage(),
                'message_important' => true
            ]);
        }

    }

}