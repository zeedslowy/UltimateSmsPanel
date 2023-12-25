<?php

namespace App\Http\Controllers;

use App\Classes\PhoneNumber;
use App\Client;
use App\ClientGroups;
use App\CustomSMSGateways;
use App\EmailTemplates;
use App\IntCountryCodes;
use App\Invoices;
use App\Jobs\SendBulkSMS;
use App\ScheduleSMS;
use App\SenderIdManage;
use App\SMSGateways;
use App\SMSHistory;
use App\SMSTransaction;
use App\SupportTickets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('client');
    }


    //======================================================================
    // allClients Function Start Here
    //======================================================================
    public function allUsers()
    {
        return view('client.all-clients');
    }

    //======================================================================
    // addClient Function Start Here
    //======================================================================
    public function addUser()
    {
        $clientGroups = ClientGroups::where('status', 'Yes')->where('created_by', Auth::guard('client')->user()->id)->get();
        return view('client.add-user', compact('clientGroups'));
    }

    //======================================================================
    // addClientPost Function Start Here
    //======================================================================
    public function addUserPost(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'first_name' => 'required', 'user_name' => 'required', 'password' => 'required', 'cpassword' => 'required', 'phone' => 'required', 'country' => 'required', 'client_group' => 'required', 'sms_limit' => 'required', 'email' => 'required', 'image' => 'image|mimes:jpeg,jpg,png,gif'
        ]);

        if ($v->fails()) {
            return redirect('user/add')->withErrors($v->errors());
        }


        $parent = Client::find(Auth::guard('client')->user()->id);

        $exist_user_name = Client::where('username', $request->user_name)->first();
        $exist_user_email = Client::where('email', $request->email)->first();

        if ($exist_user_name) {
            return redirect('user/add')->with([
                'message' => language_data('User Name already exist'),
                'message_important' => true
            ]);
        }

        if ($exist_user_email) {
            return redirect('user/add')->with([
                'message' => language_data('Email already exist'),
                'message_important' => true
            ]);
        }

        $password = $request->password;
        $cpassword = $request->cpassword;

        if ($password !== $cpassword) {
            return redirect('user/add')->with([
                'message' => language_data('Both password does not match'),
                'message_important' => true
            ]);
        } else {
            $password = bcrypt($password);
        }

        if ($request->sms_limit != '') {
            if ($parent->sms_limit < $request->sms_limit) {
                return redirect('user/add')->with([
                    'message' => language_data('You do not have enough sms balance'),
                    'message_important' => true
                ]);
            }
        }

        $image = $request->image;
        if ($image != '' && app_config('AppStage') != 'Demo') {
            if (isset($image) && in_array($image->getClientOriginalExtension(), array("png", "jpeg", "gif", 'jpg'))) {
                $destinationPath = public_path() . '/assets/client_pic/';
                $image_name = $image->getClientOriginalName();
                Input::file('image')->move($destinationPath, $image_name);
            } else {
                return redirect('user/add')->with([
                    'message' => 'Upload .png or .jpeg or .jpg or .gif file',
                    'message_important' => true
                ]);
            }

        } else {
            $image_name = 'profile.jpg';
        }

        $email_notify = $request->email_notify;
        if ($email_notify == 'yes') {
            $email_notify = 'Yes';
        } else {
            $email_notify = 'No';
        }

        $api_access = $request->api_access;
        if ($api_access == '') {
            $api_access = 'No';
        }

        $email = $request->email;


        $api_key_generate = $request->user_name . ':' . $cpassword;
        $client = new Client();
        $client->groupid = $request->client_group;
        $client->parent = $parent->id;
        $client->fname = $request->first_name;
        $client->lname = $request->last_name;
        $client->company = $request->company;
        $client->website = $request->website;
        $client->email = $email;
        $client->username = $request->user_name;
        $client->password = $password;
        $client->address1 = $request->address;
        $client->address2 = $request->more_address;
        $client->state = $request->state;
        $client->city = $request->city;
        $client->postcode = $request->postcode;
        $client->country = $request->country;
        $client->phone = $request->phone;
        $client->image = $image_name;
        $client->datecreated = date('Y-m-d');
        $client->sms_limit = $request->sms_limit;
        $client->api_access = $api_access;
        $client->api_key = base64_encode($api_key_generate);
        $client->status = 'Active';
        $client->reseller = $request->reseller_panel;
        $client->sms_gateway = $parent->sms_gateway;
        $client->emailnotify = $email_notify;
        $client->save();
        $client_id = $client->id;

        $parent->sms_limit -= $request->sms_limit;
        $parent->save();

        /*For Email Confirmation*/
        if (is_int($client_id) && $email_notify == 'Yes' && $email != '') {

            $conf = EmailTemplates::where('tplname', '=', 'Client SignUp')->first();

            $estatus = $conf->status;

            if ($estatus == '1') {

                $sysEmail = Auth::guard('client')->user()->email;
                $sysCompany = Auth::guard('client')->user()->fname . ' ' . Auth::guard('client')->user()->lname;
                $sysUrl = url('/');

                $template = $conf->message;
                $subject = $conf->subject;
                $client_name = $request->first_name . ' ' . $request->last_name;
                $data = array(
                    'name' => $client_name,
                    'business_name' => $sysCompany,
                    'from' => $sysEmail,
                    'username' => $request->user_name,
                    'email' => $email,
                    'password' => $cpassword,
                    'sys_url' => $sysUrl,
                    'template' => $template
                );

                $message = _render($template, $data);
                $mail_subject = _render($subject, $data);
                $body = $message;

                /*Set Authentication*/

                $default_gt = app_config('Gateway');

                if ($default_gt == 'default') {

                    $mail = new \PHPMailer();

                    try {
                        $mail->setFrom($sysEmail, $sysCompany);
                        $mail->addAddress($email, $client_name);     // Add a recipient
                        $mail->isHTML(true);                                  // Set email format to HTML

                        $mail->Subject = $mail_subject;
                        $mail->Body = $body;

                        if (!$mail->send()) {
                            return redirect('user/all')->with([
                                'message' => language_data('Client Added Successfully But Email Not Send')
                            ]);
                        } else {
                            return redirect('user/all')->with([
                                'message' => language_data('Client Added Successfully')
                            ]);
                        }

                    } catch (\phpmailerException $e) {
                        return redirect('user/add')->with([
                            'message' => $e->getMessage(),
                            'message_important' => true
                        ]);
                    }

                } else {
                    $host = app_config('SMTPHostName');
                    $smtp_username = app_config('SMTPUserName');
                    $stmp_password = app_config('SMTPPassword');
                    $port = app_config('SMTPPort');
                    $secure = app_config('SMTPSecure');


                    $mail = new \PHPMailer();

                    try {

                        $mail->isSMTP();                                      // Set mailer to use SMTP
                        $mail->Host = $host;  // Specify main and backup SMTP servers
                        $mail->SMTPAuth = true;                               // Enable SMTP authentication
                        $mail->Username = $smtp_username;                 // SMTP username
                        $mail->Password = $stmp_password;                           // SMTP password
                        $mail->SMTPSecure = $secure;                            // Enable TLS encryption, `ssl` also accepted
                        $mail->Port = $port;

                        $mail->setFrom($sysEmail, $sysCompany);
                        $mail->addAddress($email, $client_name);     // Add a recipient
                        $mail->isHTML(true);                                  // Set email format to HTML

                        $mail->Subject = $mail_subject;
                        $mail->Body = $body;


                        if (!$mail->send()) {
                            return redirect('user/all')->with([
                                'message' => language_data('Client Added Successfully But Email Not Send')
                            ]);
                        } else {
                            return redirect('user/all')->with([
                                'message' => language_data('Client Added Successfully')
                            ]);
                        }

                    } catch (\phpmailerException $e) {
                        return redirect('user/add')->with([
                            'message' => $e->getMessage(),
                            'message_important' => true
                        ]);
                    }
                }
            }
        }

        return redirect('user/all')->with([
            'message' => language_data('Client Added Successfully')
        ]);

    }

    //======================================================================
    // viewClient Function Start Here
    //======================================================================
    public function viewUser($id)
    {
        $client = Client::where('parent', Auth::guard('client')->user()->id)->find($id);
        if ($client) {
            $invoices = Invoices::where('cl_id', $id)->orderBy('id', 'ASC')->get();
            $tickets = SupportTickets::where('cl_id', $id)->orderBy('id', 'ASC')->get();
            $sms_transaction = SMSTransaction::where('cl_id', $id)->orderBy('id', 'ASC')->get();
            $clientGroups = ClientGroups::where('status', 'Yes')->where('created_by', Auth::guard('client')->user()->id)->get();
            return view('client.user-manage', compact('client', 'invoices', 'tickets', 'sms_gateways', 'sms_transaction', 'clientGroups'));
        } else {
            return redirect('user/all')->with([
                'message' => language_data('Client info not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // updateLimit Function Start Here
    //======================================================================
    public function updateLimit(Request $request)
    {
        $cmd = Input::get('cmd');
        $v = \Validator::make($request->all(), [
            'sms_amount' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/view/' . $cmd)->withErrors($v->errors());
        }

        $parent = Client::find(Auth::guard('client')->user()->id);

        $client = Client::where('parent', Auth::guard('client')->user()->id)->find($cmd);
        if ($client && $parent) {

            if ($request->sms_amount > $parent->sms_limit) {
                return redirect('user/view/' . $cmd)->with([
                    'message' => language_data('You do not have enough sms balance'),
                    'message_important' => true
                ]);
            }

            SMSTransaction::create([
                'cl_id' => $cmd,
                'amount' => $request->sms_amount
            ]);

            $client->sms_limit += $request->sms_amount;
            $client->save();

            $parent->sms_limit -= $request->sms_amount;
            $parent->save();

            return redirect('user/view/' . $cmd)->with([
                'message' => language_data('Limit updated successfully')
            ]);
        } else {
            return redirect('user/all')->with([
                'message' => language_data('Client info not found'),
                'message_important' => true
            ]);
        }

    }

    //======================================================================
    // updateImage Function Start Here
    //======================================================================
    public function updateImage(Request $request)
    {
        $cmd = Input::get('cmd');
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('user/view/' . $cmd)->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'client_image' => 'required |image| mimes:jpeg,jpg,png,gif',
        ]);

        if ($v->fails()) {
            return redirect('user/view/' . $cmd)->withErrors($v->errors());
        }

        $client = Client::where('parent', Auth::guard('client')->user()->id)->find($cmd);
        if ($client) {
            $image = $request->client_image;
            if ($image != '') {
                if (isset($image) && in_array($image->getClientOriginalExtension(), array("png", "jpeg", "gif", 'jpg'))) {

                    $destinationPath = public_path() . '/assets/client_pic/';
                    $image_name = $image->getClientOriginalName();
                    Input::file('client_image')->move($destinationPath, $image_name);

                    $client->image = $image_name;
                    $client->save();

                    return redirect('user/view/' . $cmd)->with([
                        'message' => language_data('Image updated successfully')
                    ]);
                } else {
                    return redirect('user/view/' . $cmd)->with([
                        'message' => 'Upload .png or .jpeg or .jpg or .gif file',
                        'message_important' => true
                    ]);
                }
            } else {
                return redirect('user/view/' . $cmd)->with([
                    'message' => language_data('Please try again'),
                    'message_important' => true
                ]);
            }
        } else {
            return redirect('user/all')->with([
                'message' => language_data('Client info not found'),
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // updateClient Function Start Here
    //======================================================================
    public function updateUser(Request $request)
    {
        $cmd = Input::get('cmd');
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('user/view/' . $cmd)->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'first_name' => 'required', 'user_name' => 'required', 'phone' => 'required', 'country' => 'required', 'client_group' => 'required', 'status' => 'required', 'email' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/view/' . $cmd)->withErrors($v->errors());
        }

        $client = Client::where('parent', Auth::guard('client')->user()->id)->find($cmd);
        if ($client) {
            if ($client->username != $request->user_name) {
                $exist_user_name = Client::where('username', $request->user_name)->first();
                if ($exist_user_name) {
                    return redirect('user/view/' . $cmd)->with([
                        'message' => language_data('User Name already exist'),
                        'message_important' => true
                    ]);
                }
            }

            if ($client->email != $request->email) {

                $exist_user_email = Client::where('email', $request->email)->first();
                if ($exist_user_email) {
                    return redirect('user/view/' . $cmd)->with([
                        'message' => language_data('Email already exist'),
                        'message_important' => true
                    ]);
                }
            }

            $password = $request->password;

            if ($password != '') {
                $password = bcrypt($password);
            } else {
                $password = $client->password;
            }

            $api_access = $request->api_access;
            if ($request->api_access == '') {
                $api_access = 'No';
            }

            $client->groupid = $request->client_group;
            $client->fname = $request->first_name;
            $client->lname = $request->last_name;
            $client->company = $request->company;
            $client->website = $request->website;
            $client->email = $request->email;
            $client->username = $request->user_name;
            $client->password = $password;
            $client->address1 = $request->address;
            $client->address2 = $request->more_address;
            $client->state = $request->state;
            $client->city = $request->city;
            $client->postcode = $request->postcode;
            $client->country = $request->country;
            $client->phone = $request->phone;
            $client->api_access = $api_access;
            $client->status = $request->status;
            $client->reseller = $request->reseller_panel;
            $client->sms_gateway = Auth::guard('client')->user()->sms_gateway;
            $client->save();

            return redirect('user/view/' . $cmd)->with([
                'message' => language_data('Client updated successfully')
            ]);
        } else {
            return redirect('user/all')->with([
                'message' => language_data('Client info not found'),
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // sendSMS Function Start Here
    //======================================================================
    public function sendSMS(Request $request)
    {
        $cmd = Input::get('cmd');

        $v = \Validator::make($request->all(), [
            'message' => 'required', 'message_type' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/view/' . $cmd)->withErrors($v->errors());
        }

        $client = Client::find(Auth::guard('client')->user()->id);
        if ($client == '') {
            return redirect('user/view/' . $cmd)->with([
                'message' => language_data('Client info not found'),
                'message_important' => true
            ]);
        }

        $gateway = SMSGateways::find($client->sms_gateway);
        if ($gateway->status != 'Active') {
            return redirect('user/view/' . $cmd)->with([
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
        $sender_id = $request->sender_id;

        $msgcount = strlen(preg_replace('/\s+/', ' ', trim($message)));

        $msg_type = $request->message_type;

        if ($msg_type != 'plain' && $msg_type != 'unicode') {
            return redirect('user/view/' . $cmd)->with([
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
            $msgcount = mb_strlen(preg_replace('/\s+/', ' ', trim($message)), 'UTF-8');

            if ($msgcount <= 70) {
                $msgcount = 1;
            } else {
                $msgcount = $msgcount / 67;
            }
        }

        $msgcount = ceil($msgcount);


        $phone = str_replace(['(', ')', '+', '-', ' '], '', $request->phone_number);
        $c_phone = PhoneNumber::get_code($phone);

        $sms_cost = IntCountryCodes::where('country_code', $c_phone)->where('active', '1')->first();

        if ($sms_cost) {
            $total_cost = $sms_cost->tariff * $msgcount;

            if ($total_cost == 0) {
                return redirect('user/view/' . $cmd)->with([
                    'message' => language_data('You do not have enough sms balance'),
                    'message_important' => true
                ]);
            }

            if ($total_cost > $client->sms_limit) {
                return redirect('user/view/' . $cmd)->with([
                    'message' => language_data('You do not have enough sms balance'),
                    'message_important' => true
                ]);
            }
        } else {
            return redirect('user/view/' . $cmd)->with([
                'message' => language_data('Phone Number Coverage are not active'),
                'message_important' => true
            ]);
        }

        if ($sender_id != '') {
            $all_sender_id = SenderIdManage::all();
            $all_ids = [];

            foreach ($all_sender_id as $sid) {
                $client_array = json_decode($sid->cl_id);

                if (in_array('0', $client_array)) {
                    array_push($all_ids, $sender_id);
                } elseif (in_array(Auth::guard('client')->user()->id, $client_array)) {
                    array_push($all_ids, $sid->sender_id);
                }
            }
            $all_ids = array_unique($all_ids);

            if (!in_array($sender_id, $all_ids)) {
                return redirect('user/sms/send-single-sms')->with([
                    'message' => language_data('This Sender ID have Blocked By Administrator'),
                    'message_important' => true
                ]);
            }
        }

        $this->dispatch(new SendBulkSMS($cmd, $client->phone, $gateway, $sender_id, $message, $msgcount, $cg_info, '', $msg_type));

        $remain_sms = $client->sms_limit - $total_cost;
        $client->sms_limit = $remain_sms;
        $client->save();

        return redirect('user/view/' . $cmd)->with([
            'message' => language_data('Please check sms history')
        ]);
    }



    //======================================================================
    // exportImport Function Start Here
    //======================================================================
    public function exportImport()
    {
        $client_groups = ClientGroups::where('status', 'Yes')->where('created_by', Auth::guard('client')->user()->id)->get();
        return view('client.export-n-import', compact('client_groups'));
    }


    //======================================================================
    // exportUsers Function Start Here
    //======================================================================
    public function exportUsers()
    {
        Excel::create('Clients', function ($excel) {
            $excel->sheet('Sheetname', function ($sheet) {
                $sheet->fromModel(Client::where('parent', Auth::guard('client')->user()->id)->get());
            });

        })->export('csv');
    }

    //======================================================================
    // downloadSampleCSV Function Start Here
    //======================================================================
    public function downloadSampleCSV()
    {
        return response()->download('assets/test_file/test_file.csv');
    }

    /**
     * @param $array
     * @param $key
     * @return array
     */
    public function checkUsername($array, $key, $client_group = '0', $sms_gateway = '1')
    {
        $client_data = [];
        $i = 0;
        $key_array = [];
        $keep_ids = [];
        $final_data = [];
        $parent = Auth::guard('client')->user()->id;
        $api_access = client_info($parent)->api_access;

        foreach ($array as $k => $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $client_data[$i] = $val;
                if (!array_key_exists('id', $client_data[$k])) {
                    $client_data[$k]['password'] = bcrypt($val['password']);
                    $client_data[$k]['groupid'] = $client_group;
                    $client_data[$k]['parent'] = $parent;
                    if ($api_access == 'No') {
                        $client_data[$k]['api_access'] = $api_access;
                    }
                    $client_data[$k]['sms_gateway'] = $sms_gateway;
                    $client_data[$k]['created_at'] = Carbon::now(app_config('Timezone'));
                    $client_data[$k]['updated_at'] = Carbon::now(app_config('Timezone'));
                    array_push($keep_ids, $k);
                }
            }
            $i++;
        }
        foreach ($keep_ids as $v) {
            if (array_key_exists($v, $client_data)) {
                array_push($final_data, $client_data[$v]);
            }
        }
        return $final_data;
    }

    /**
     * @param $array
     * @return mixed
     */
    public function prepareForInsert($array)
    {
        foreach ($array as $k => $v) {
            if (!array_key_exists('id', $v)) {
                $array[$k] ['fname'] = $array[$k] ['first_name'];
                $array[$k] ['lname'] = $array[$k] ['last_name'];
                $array[$k] ['address1'] = $array[$k] ['address'];
                $array[$k] ['address2'] = $array[$k] ['more_address'];
                $array[$k] ['postcode'] = $array[$k] ['zip_code'];
                unset($array[$k]['first_name']);
                unset($array[$k]['last_name']);
                unset($array[$k]['address']);
                unset($array[$k]['more_address']);
                unset($array[$k]['zip_code']);
            }
        }
        $array = array_map('array_filter', $array);
        return $array;
    }


    //======================================================================
    // addNewUserCSV Function Start Here
    //======================================================================
    public function addNewUserCSV(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('user/export-n-import')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'import_client' => 'required', 'client_group' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/export-n-import')->withErrors($v->errors());
        }

        $file_extension = Input::file('import_client')->getClientOriginalExtension();

        $supportedExt = array('csv', 'xls', 'xlsx');

        if (!in_array_r($file_extension, $supportedExt)) {
            return redirect('user/export-n-import')->with([
                'message' => language_data('Insert Valid Excel or CSV file'),
                'message_important' => true
            ]);
        }

        $client_group = Input::get('client_group');

        $existing_clients = Client::all()->toArray();
        $results = Excel::load($request->import_client)->get()->toArray();
        $client_data = array_merge($existing_clients, $results);


        $details = $this->checkUsername($client_data, 'username', $client_group, Auth::guard('client')->user()->sms_gateway);
        $final_data = $this->prepareForInsert($details);

        Client::insert($final_data);

        return redirect('user/all')->with([
            'message' => language_data('Client imported successfully')
        ]);
    }



    //======================================================================
    // userGroups Function Start Here
    //======================================================================
    public function userGroups()
    {
        $clientGroups = ClientGroups::where('created_by', Auth::guard('client')->user()->id)->get();
        return view('client.client-groups', compact('clientGroups'));
    }

    //======================================================================
    // addNewUserGroup Function Start Here
    //======================================================================
    public function addNewUserGroup(Request $request)
    {

        $v = \Validator::make($request->all(), [
            'group_name' => 'required', 'status' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('users/groups')->withErrors($v->errors());
        }

        $clientGroup = new ClientGroups();
        $clientGroup->group_name = $request->group_name;
        $clientGroup->created_by = Auth::guard('client')->user()->id;
        $clientGroup->status = $request->status;
        $clientGroup->save();

        return redirect('users/groups')->with([
            'message' => language_data('Client Group added successfully')
        ]);

    }

    //======================================================================
    // updateClientGroup Function Start Here
    //======================================================================
    public function updateUserGroup(Request $request)
    {
        $cmd = $request->cmd;

        $v = \Validator::make($request->all(), [
            'group_name' => 'required', 'status' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('users/groups')->withErrors($v->errors());
        }

        $clientGroup = ClientGroups::where('created_by', Auth::guard('client')->user()->id)->find($cmd);

        if ($clientGroup) {
            $clientGroup->group_name = $request->group_name;
            $clientGroup->status = $request->status;
            $clientGroup->save();

            return redirect('users/groups')->with([
                'message' => language_data('Client Group updated successfully')
            ]);

        } else {
            return redirect('users/groups')->with([
                'message' => language_data('Client Group not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // exportClientGroup Function Start Here
    //======================================================================
    public function exportUserGroup($id)
    {
        Excel::create('Clients', function ($excel) use ($id) {
            $excel->sheet('Sheetname', function ($sheet) use ($id) {
                $sheet->fromModel(Client::where('groupid', $id)->get());
            });

        })->export('csv');
    }


    //======================================================================
    // deleteUserGroup Function Start Here
    //======================================================================
    public function deleteUserGroup($id)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('users/groups')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $clientGroup = ClientGroups::where('created_by', Auth::guard('client')->user()->id)->find($id);

        if ($clientGroup) {
            $exist_client = Client::where('groupid', $id)->first();
            if ($exist_client) {
                return redirect('users/groups')->with([
                    'message' => language_data('This Group exist in a client'),
                    'message_important' => true
                ]);
            }

            $clientGroup->delete();

            return redirect('users/groups')->with([
                'message' => language_data('Client group deleted successfully')
            ]);

        } else {
            return redirect('users/groups')->with([
                'message' => language_data('Client Group not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // deleteUser Function Start Here
    //======================================================================
    public function deleteUser($id)
    {

        //check client info
        $client = Client::find($id);
        if ($client) {

            //Check Client Group
            $client_group = ClientGroups::where('created_by', $id)->first();

            if ($client_group) {
                return redirect('user/all')->with([
                    'message' => language_data('Client contain in') . ' ' . language_data('Client Group'),
                    'message_important' => true
                ]);
            }


            //Check Invoice
            $client_inv = Invoices::where('cl_id', $id)->first();

            if ($client_inv) {
                return redirect('user/all')->with([
                    'message' => language_data('Client contain in') . ' ' . language_data('Invoice'),
                    'message_important' => true
                ]);
            }


            //Check SMS History
            $client_sms = SMSHistory::where('userid', $id)->first();

            if ($client_sms) {
                return redirect('user/all')->with([
                    'message' => language_data('Client contain in') . ' ' . language_data('SMS History'),
                    'message_important' => true
                ]);
            }

            //Check Schedule SMS History
//            $client_schedule_sms=ScheduleSMS::where('userid',$id)->first();
//
//            if ($client_schedule_sms){
//                return redirect('user/all')->with([
//                    'message' => language_data('Client contain in').' '.language_data('SMS History')
//                ]);
//            }

            //Check Sender ID
            $client_sender_id = SenderIdManage::where('cl_id', $id)->first();

            if ($client_sender_id) {
                return redirect('user/all')->with([
                    'message' => language_data('Client contain in') . ' ' . language_data('Sender ID'),
                    'message_important' => true
                ]);
            }

            //Check Client SMS Balance
            if ($client->sms_limit > 0) {
                return redirect('user/all')->with([
                    'message' => language_data('Client sms limit not empty'),
                    'message_important' => true
                ]);
            }


            //Check Parent
            $parents = Client::where('parent', $id)->first();

            if ($parents) {
                return redirect('user/all')->with([
                    'message' => language_data('This client have some customer'),
                    'message_important' => true
                ]);
            }

            //Check Support Tickets
            $client_tickets = SupportTickets::where('cl_id', $id)->first();

            if ($client_tickets) {
                return redirect('user/all')->with([
                    'message' => language_data('Client contain in') . ' ' . language_data('Support Tickets'),
                    'message_important' => true
                ]);
            }

            // Delete Schedule SMS N SMS Transaction
            ScheduleSMS::where('userid', $id)->delete();
            SMSTransaction::where('cl_id', $id)->delete();

            //Delete Client
            $client->delete();

            return redirect('clients/all')->with([
                'message' => language_data('Client delete successfully')
            ]);

        } else {
            return redirect('clients/all')->with([
                'message' => language_data('Client info not found'),
                'message_important' => true
            ]);
        }

    }



    //======================================================================
    // getAllClients Function Start Here
    //======================================================================
    public function getAllClients()
    {
        $clients = Client::where('parent', Auth::guard('client')->user()->id)->select(['id', 'fname', 'lname', 'username', 'datecreated', 'status']);
        return Datatables::of($clients)
            ->addColumn('action', function ($cl) {
                return '
                <a class="btn btn-success btn-xs" href="' . url("user/view/$cl->id") . '" ><i class="fa fa-edit"></i>' . language_data('Manage') . '</a>
                <a href="#" id="' . $cl->id . '" class="cdelete btn btn-xs btn-danger"><i class="fa fa-danger"></i> ' . language_data('Delete') . '</a>
                ';
            })
            ->addColumn('name', function ($cl) {
                return $cl->fname . ' ' . $cl->lnamge;
            })
            ->addColumn('datecreated', function ($cl) {
                return get_date_format($cl->datecreated);
            })
            ->addColumn('status', function ($cl) {
                if ($cl->status == 'Active') {
                    return '<p class="text-success">' . language_data("Active") . '</p>';
                } elseif ($cl->status == 'Inactive') {
                    return '<p class="text-warning">' . language_data("Inactive") . '</p>';
                } else {
                    return '<p class="text-danger">' . language_data("Closed") . '</p>';
                }
            })
            ->escapeColumns([])
            ->make(true);
    }

}
