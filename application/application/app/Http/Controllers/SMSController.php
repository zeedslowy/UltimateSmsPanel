<?php

namespace App\Http\Controllers;

use App\AppConfig;
use App\BlackListContact;
use App\Classes\Permission;
use App\Client;
use App\ClientGroups;
use App\ContactList;
use App\CustomSMSGateways;
use App\ImportPhoneNumber;
use App\IntCountryCodes;
use App\Jobs\SendBulkSMS;
use App\ScheduleSMS;
use App\SenderIdManage;
use App\SMSBundles;
use App\SMSGateways;
use App\SMSPlanFeature;
use App\SMSPricePlan;
use App\SMSTemplates;
use App\StoreBulkSMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class SMSController extends Controller
{
    /**
     * SMSController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    //======================================================================
    // coverage Function Start Here
    //======================================================================
    public function coverage()
    {

        $self = 'coverage';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $country_codes = IntCountryCodes::all();
        return view('admin.coverage', compact('country_codes'));
    }

    //======================================================================
    // manageCoverage Function Start Here
    //======================================================================
    public function manageCoverage($id)
    {
        $self = 'coverage';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $coverage = IntCountryCodes::find($id);
        if ($coverage) {
            return view('admin.manage-coverage', compact('coverage'));
        } else {
            return redirect('sms/coverage')->with([
                'message' => language_data('Information not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // postManageCoverage Function Start Here
    //======================================================================
    public function postManageCoverage(Request $request)
    {
        $cmd = Input::get('cmd');

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('sms/manage-coverage/' . $cmd)->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $self = 'coverage';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'tariff' => 'required', 'status' => 'required'
        ]);
        if ($v->fails()) {
            return redirect('sms/manage-coverage/' . $cmd)->withErrors($v->errors());
        }

        $coverage = IntCountryCodes::find($cmd);
        if ($coverage) {

            $coverage->tariff = $request->tariff;
            $coverage->active = $request->status;
            $coverage->save();

            return redirect('sms/manage-coverage/' . $cmd)->with([
                'message' => language_data('Coverage updated successfully')
            ]);

        } else {
            return redirect('sms/coverage')->with([
                'message' => language_data('Information not found'),
                'message_important' => true
            ]);
        }

    }

    //======================================================================
    // senderIdManagement Function Start Here
    //======================================================================
    public function senderIdManagement()
    {

        $self = 'sender-id-management';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $sender_id = SenderIdManage::all();
        return view('admin.sender-id-management', compact('sender_id'));
    }

    //======================================================================
    // addSenderID Function Start Here
    //======================================================================
    public function addSenderID()
    {
        $self = 'sender-id-management';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $clients = Client::where('status', 'Active')->get();
        return view('admin.add-sender-id', compact('clients'));
    }

    //======================================================================
    // postNewSenderID Function Start Here
    //======================================================================
    public function postNewSenderID(Request $request)
    {
        $self = 'sender-id-management';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'client_id' => 'required', 'status' => 'required', 'sender_id' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/add-sender-id')->withErrors($v->errors());
        }
        $sender_ids = $request->sender_id;
        $clients_id = $request->client_id;

        if (is_array($clients_id) && count($clients_id) <= 0) {
            return redirect('sms/add-sender-id')->with([
                'message' => 'Select Client',
                'message_important' => true
            ]);
        }

        if (is_array($sender_ids) && count($sender_ids) <= 0) {
            return redirect('sms/add-sender-id')->with([
                'message' => 'Insert Sender id',
                'message_important' => true
            ]);
        }

        $clients_id = json_encode($clients_id, true);

        if (is_array($sender_ids)) {
            foreach ($sender_ids as $ids) {
                if ($ids){
                    $sender_id = new SenderIdManage();
                    $sender_id->sender_id = $ids;
                    $sender_id->cl_id = $clients_id;
                    $sender_id->status = $request->status;
                    $sender_id->save();
                }
            }
        }

        return redirect('sms/sender-id-management')->with([
            'message' => language_data('Sender Id added successfully')
        ]);

    }

    //======================================================================
    // viewSenderID Function Start Here
    //======================================================================
    public function viewSenderID($id)
    {
        $self = 'sender-id-management';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $senderId = SenderIdManage::find($id);
        if ($senderId) {
            $clients = Client::where('status', 'Active')->get();
            $sender_id_clients = json_decode($senderId->cl_id);
            if (is_array($sender_id_clients) && in_array('0', $sender_id_clients)) {
                $selected_all = true;
            } else {
                $selected_all = false;
            }

            return view('admin.manage-sender-id', compact('clients', 'senderId', 'sender_id_clients', 'selected_all'));
        } else {
            return redirect('sms/sender-id-management')->with([
                'message' => language_data('Sender Id not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // postUpdateSenderID Function Start Here
    //======================================================================
    public function postUpdateSenderID(Request $request)
    {
        $self = 'sender-id-management';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $cmd = Input::get('cmd');

        $v = \Validator::make($request->all(), [
            'client_id' => 'required', 'status' => 'required', 'sender_id' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/view-sender-id/' . $cmd)->withErrors($v->errors());
        }

        $senderId = SenderIdManage::find($cmd);
        if ($senderId) {
            $senderId->sender_id = $request->sender_id;
            $senderId->cl_id = json_encode($request->client_id);
            $senderId->status = $request->status;
            $senderId->save();
            return redirect('sms/sender-id-management')->with([
                'message' => language_data('Sender id updated successfully')
            ]);
        } else {
            return redirect('sms/sender-id-management')->with([
                'message' => language_data('Sender Id not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // deleteSenderID Function Start Here
    //======================================================================
    public function deleteSenderID($id)
    {
        $self = 'sender-id-management';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $senderId = SenderIdManage::find($id);
        if ($senderId) {
            $senderId->delete();

            return redirect('sms/sender-id-management')->with([
                'message' => language_data('Sender id deleted successfully')
            ]);

        } else {
            return redirect('sms/sender-id-management')->with([
                'message' => language_data('Sender Id not found'),
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // pricePlan Function Start Here
    //======================================================================
    public function pricePlan()
    {
        $self = 'sms-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $price_plan = SMSPricePlan::all();
        return view('admin.sms-price-plan', compact('price_plan'));
    }

    //======================================================================
    // addPricePlan Function Start Here
    //======================================================================
    public function addPricePlan()
    {
        $self = 'add-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }
        return view('admin.add-price-plan');
    }

    //======================================================================
    // postNewPricePlan Function Start Here
    //======================================================================
    public function postNewPricePlan(Request $request)
    {
        $self = 'add-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'plan_name' => 'required', 'price' => 'required', 'show_in_client' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/add-price-plan')->withErrors($v->errors());
        }

        $exist_plan = SMSPricePlan::where('plan_name', $request->plan_name)->first();
        if ($exist_plan) {
            return redirect('sms/add-price-plan')->with([
                'message' => language_data('Plan already exist'),
                'message_important' => true
            ]);
        }

        $plan = new SMSPricePlan();
        $plan->plan_name = $request->plan_name;
        $plan->price = $request->price;
        $plan->popular = $request->popular;
        $plan->status = $request->show_in_client;
        $plan->save();

        return redirect('sms/price-plan')->with([
            'message' => language_data('Plan added successfully')
        ]);

    }


    //======================================================================
    // managePricePlan Function Start Here
    //======================================================================
    public function managePricePlan($id)
    {
        $self = 'sms-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $price_plan = SMSPricePlan::find($id);
        if ($price_plan) {
            return view('admin.manage-price-plan', compact('price_plan'));
        } else {
            return redirect('sms/price-plan')->with([
                'message' => language_data('Plan not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // postManagePricePlan Function Start Here
    //======================================================================
    public function postManagePricePlan(Request $request)
    {
        $self = 'sms-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }
        $cmd = Input::get('cmd');
        $v = \Validator::make($request->all(), [
            'plan_name' => 'required', 'price' => 'required', 'show_in_client' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/manage-price-plan/' . $cmd)->withErrors($v->errors());
        }
        $plan = SMSPricePlan::find($cmd);

        if ($plan) {
            if ($plan->plan_name != $request->plan_name) {
                $exist_plan = SMSPricePlan::where('plan_name', $request->plan_name)->first();
                if ($exist_plan) {
                    return redirect('sms/manage-price-plan/' . $cmd)->with([
                        'message' => language_data('Plan already exist'),
                        'message_important' => true
                    ]);
                }
            }

            $plan->plan_name = $request->plan_name;
            $plan->price = $request->price;
            $plan->popular = $request->popular;
            $plan->status = $request->show_in_client;
            $plan->save();

            return redirect('sms/price-plan')->with([
                'message' => language_data('Plan updated successfully')
            ]);
        } else {
            return redirect('sms/price-plan')->with([
                'message' => language_data('Plan not found'),
                'message_important' => true
            ]);
        }


    }



    //======================================================================
    // addPlanFeature Function Start Here
    //======================================================================
    public function addPlanFeature($id)
    {
        $self = 'sms-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $price_plan = SMSPricePlan::find($id);
        if ($price_plan) {
            return view('admin.add-plan-feature', compact('price_plan'));
        } else {
            return redirect('sms/price-plan')->with([
                'message' => language_data('Plan not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // postNewPlanFeature Function Start Here
    //======================================================================
    public function postNewPlanFeature(Request $request)
    {
        $self = 'sms-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $cmd = Input::get('cmd');
        $v = \Validator::make($request->all(), [
            'feature_name' => 'required', 'feature_value' => 'required', 'show_in_client' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/add-plan-feature/' . $cmd)->withErrors($v->errors());
        }

        $price_plan = SMSPricePlan::find($cmd);
        if ($price_plan) {
            $feature_name = $request->feature_name;
            $feature_value = $request->feature_value;

            foreach ($feature_name as $key => $value) {
                SMSPlanFeature::create([
                    'pid' => $cmd,
                    'feature_name' => $value,
                    'feature_value' => $feature_value[$key],
                    'status' => $request->show_in_client
                ]);
            }

            return redirect('sms/price-plan')->with([
                'message' => language_data('Plan features added successfully')
            ]);

        } else {
            return redirect('sms/price-plan')->with([
                'message' => language_data('Plan not found'),
                'message_important' => true
            ]);
        }

    }

    //======================================================================
    // viewPlanFeature Function Start Here
    //======================================================================
    public function viewPlanFeature($id)
    {
        $self = 'sms-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $features = SMSPlanFeature::where('pid', $id)->get();
        return view('admin.view-plan-feature', compact('features'));

    }

    //======================================================================
    // managePlanFeature Function Start Here
    //======================================================================
    public function managePlanFeature($id)
    {
        $self = 'sms-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $plan_feature = SMSPlanFeature::find($id);
        if ($plan_feature) {
            return view('admin.manage-plan-feature', compact('plan_feature'));
        } else {
            return redirect('sms/view-plan-feature/' . $id)->with([
                'message' => language_data('Plan feature not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // postManagePlanFeature Function Start Here
    //======================================================================
    public function postManagePlanFeature(Request $request)
    {
        $self = 'sms-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $cmd = Input::get('cmd');

        $v = \Validator::make($request->all(), [
            'feature_name' => 'required', 'feature_value' => 'required', 'show_in_client' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/manage-plan-feature/' . $cmd)->withErrors($v->errors());
        }


        $plan_feature = SMSPlanFeature::find($cmd);
        if ($plan_feature->feature_name != $request->feature_name) {
            $exist = SMSPlanFeature::where('feature_name', $request->feature_name)->where('pid', $plan_feature->pid)->first();
            if ($exist) {
                return redirect('sms/manage-plan-feature/' . $cmd)->with([
                    'message' => language_data('Feature already exist'),
                    'message_important' => true
                ]);
            }
        }

        if ($plan_feature) {
            $plan_feature->feature_name = $request->feature_name;
            $plan_feature->feature_value = $request->feature_value;
            $plan_feature->status = $request->show_in_client;
            $plan_feature->save();

            return redirect('sms/view-plan-feature/' . $plan_feature->pid)->with([
                'message' => language_data('Feature updated successfully')
            ]);

        } else {
            return redirect('sms/price-plan')->with([
                'message' => language_data('Plan feature not found'),
                'message_important' => true
            ]);
        }
    }



    //======================================================================
    // deletePlanFeature Function Start Here
    //======================================================================
    public function deletePlanFeature($id)
    {
        $self = 'sms-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $plan_feature = SMSPlanFeature::find($id);
        if ($plan_feature) {
            $pid = $plan_feature->pid;
            $plan_feature->delete();
            return redirect('sms/view-plan-feature/' . $pid)->with([
                'message' => language_data('Plan feature deleted successfully')
            ]);
        } else {
            return redirect('sms/price-plan')->with([
                'message' => language_data('Plan feature not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // deletePricePlan Function Start Here
    //======================================================================
    public function deletePricePlan($id)
    {
        $self = 'sms-price-plan';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $price_plan = SMSPricePlan::find($id);
        if ($price_plan) {
            SMSPlanFeature::where('pid', $id)->delete();
            $price_plan->delete();
            return redirect('sms/price-plan')->with([
                'message' => language_data('Price Plan deleted successfully')
            ]);
        } else {
            return redirect('sms/price-plan')->with([
                'message' => language_data('Plan feature not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // httpSmsGateways Function Start Here
    //======================================================================
    public function httpSmsGateways()
    {
        $self = 'sms-gateways';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $gateways = SMSGateways::where('type', 'http')->get();
        return view('admin.sms-gateways', compact('gateways'));
    }

    //======================================================================
    // smppSmsGateways Function Start Here
    //======================================================================
    public function smppSmsGateways()
    {
        $self = 'sms-gateways';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $gateways = SMSGateways::where('type', 'smpp')->get();
        return view('admin.sms-gateways', compact('gateways'));
    }


    //======================================================================
    // addSmsGateway Function Start Here
    //======================================================================
    public function addSmsGateway()
    {
        $self = 'add-sms-gateway';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        return view('admin.add-sms-gateway');
    }

    //======================================================================
    // postNewSmsGateway Function Start Here
    //======================================================================
    public function postNewSmsGateway(Request $request)
    {
        $self = 'add-sms-gateway';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'gateway_name' => 'required', 'gateway_link' => 'required', 'status' => 'required', 'destination_param' => 'required', 'message_param' => 'required', 'username_param' => 'required', 'username_value' => 'required', 'schedule' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/add-sms-gateways')->withErrors($v->errors());
        }

        $exist_gateway = SMSGateways::where('name', $request->gateway_name)->first();
        if ($exist_gateway) {
            return redirect('sms/add-sms-gateways')->with([
                'message' => language_data('Gateway already exist'),
                'message_important' => true
            ]);
        }

        $gateway = new SMSGateways();
        $gateway->name = $request->gateway_name;
        $gateway->api_link = $request->gateway_link;
        $gateway->username = '';
        $gateway->password = '';
        $gateway->api_id = '';
        $gateway->schedule = $request->schedule;
        $gateway->custom = 'Yes';
        $gateway->status = $request->status;
        $gateway->two_way = 'No';
        $gateway->save();

        $gateway_id = $gateway->id;

        if (is_int($gateway_id)) {
            $cgateway = new CustomSMSGateways();
            $cgateway->gateway_id = $gateway_id;
            $cgateway->username_param = $request->username_param;
            $cgateway->username_value = $request->username_value;

            $cgateway->password_param = $request->password_param;
            $cgateway->password_value = $request->password_value;
            $cgateway->password_status = $request->password_status;

            $cgateway->action_param = $request->action_param;
            $cgateway->action_value = $request->action_value;
            $cgateway->action_status = $request->action_status;

            $cgateway->source_param = $request->source_param;
            $cgateway->source_value = $request->source_value;
            $cgateway->source_status = $request->source_status;

            $cgateway->destination_param = $request->destination_param;
            $cgateway->message_param = $request->message_param;

            $cgateway->unicode_param = $request->unicode_param;
            $cgateway->unicode_value = $request->unicode_value;
            $cgateway->unicode_status = $request->unicode_status;

            $cgateway->route_param = $request->route_param;
            $cgateway->route_value = $request->route_value;
            $cgateway->route_status = $request->route_status;

            $cgateway->language_param = $request->language_param;
            $cgateway->language_value = $request->language_value;
            $cgateway->language_status = $request->language_status;

            $cgateway->custom_one_param = $request->custom_one_param;
            $cgateway->custom_one_value = $request->custom_one_value;
            $cgateway->custom_one_status = $request->custom_one_status;

            $cgateway->custom_two_param = $request->custom_two_param;
            $cgateway->custom_two_value = $request->custom_two_value;
            $cgateway->custom_two_status = $request->custom_two_status;

            $cgateway->custom_three_param = $request->custom_three_param;
            $cgateway->custom_three_value = $request->custom_three_value;
            $cgateway->custom_three_status = $request->custom_three_status;

            $cgateway->save();

            return redirect('sms/http-sms-gateway')->with([
                'message' => language_data('Custom gateway added successfully')
            ]);
        } else {
            SMSGateways::where('id', $gateway_id)->delete();
            return redirect('sms/add-sms-gateways')->with([
                'message' => language_data('Parameter or Value is empty'),
                'message_important' => true
            ]);
        }

    }

    //======================================================================
    // customSmsGatewayManage Function Start Here
    //======================================================================
    public function customSmsGatewayManage($id)
    {
        $self = 'sms-gateways';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $gateway = SMSGateways::find($id);
        if ($gateway) {
            $gateway_info = CustomSMSGateways::where('gateway_id', $id)->first();
            return view('admin.manage-custom-sms-gateway', compact('gateway', 'gateway_info'));
        } else {
            return redirect('sms/http-sms-gateway')->with([
                'message' => language_data('Gateway information not found'),
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // postCustomSmsGateway Function Start Here
    //======================================================================
    public function postCustomSmsGateway(Request $request)
    {
        $self = 'sms-gateways';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $cmd = Input::get('cmd');

        $v = \Validator::make($request->all(), [
            'gateway_name' => 'required', 'gateway_link' => 'required', 'status' => 'required', 'destination_param' => 'required', 'message_param' => 'required', 'username_param' => 'required', 'username_value' => 'required', 'schedule' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/custom-gateway-manage/' . $cmd)->withErrors($v->errors());
        }

        $gateway = SMSGateways::find($cmd);
        $gateway_name = $request->gateway_name;

        if ($gateway->custom == 'Yes') {
            if ($gateway_name == '') {
                return redirect('sms/custom-gateway-manage/' . $cmd)->with([
                    'message' => language_data('Gateway name required'),
                    'message_important' => true
                ]);
            }
        } else {
            $gateway_name = $gateway->name;
        }

        if ($gateway->name != $gateway_name) {
            $exist_gateway = SMSGateways::where('name', $gateway_name)->first();
            if ($exist_gateway) {
                return redirect('sms/custom-gateway-manage/' . $cmd)->with([
                    'message' => language_data('Gateway already exist'),
                    'message_important' => true
                ]);
            }
        }

        $gateway->name = $request->gateway_name;
        $gateway->api_link = $request->gateway_link;
        $gateway->schedule = $request->schedule;
        $gateway->status = $request->status;
        $gateway->save();

        if ($cmd) {
            $cgateway = CustomSMSGateways::where('gateway_id', $cmd)->first();

            $cgateway->username_param = $request->username_param;
            $cgateway->username_value = $request->username_value;

            $cgateway->password_param = $request->password_param;
            $cgateway->password_value = $request->password_value;
            $cgateway->password_status = $request->password_status;

            $cgateway->action_param = $request->action_param;
            $cgateway->action_value = $request->action_value;
            $cgateway->action_status = $request->action_status;

            $cgateway->source_param = $request->source_param;
            $cgateway->source_value = $request->source_value;
            $cgateway->source_status = $request->source_status;

            $cgateway->destination_param = $request->destination_param;
            $cgateway->message_param = $request->message_param;

            $cgateway->route_param = $request->route_param;
            $cgateway->route_value = $request->route_value;
            $cgateway->route_status = $request->route_status;

            $cgateway->language_param = $request->language_param;
            $cgateway->language_value = $request->language_value;
            $cgateway->language_status = $request->language_status;

            $cgateway->custom_one_param = $request->custom_one_param;
            $cgateway->custom_one_value = $request->custom_one_value;
            $cgateway->custom_one_status = $request->custom_one_status;

            $cgateway->custom_two_param = $request->custom_two_param;
            $cgateway->custom_two_value = $request->custom_two_value;
            $cgateway->custom_two_status = $request->custom_two_status;

            $cgateway->custom_three_param = $request->custom_three_param;
            $cgateway->custom_three_value = $request->custom_three_value;
            $cgateway->custom_three_status = $request->custom_three_status;

            $cgateway->save();

            return redirect('sms/http-sms-gateway')->with([
                'message' => language_data('Custom gateway updated successfully')
            ]);
        } else {
            return redirect('sms/add-sms-gateways')->with([
                'message' => language_data('Parameter or Value is empty'),
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // smsGatewayManage Function Start Here
    //======================================================================
    public function smsGatewayManage($id)
    {
        $self = 'sms-gateways';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $gateway = SMSGateways::find($id);
        if ($gateway) {
            return view('admin.manage-sms-gateway', compact('gateway'));
        } else {
            return redirect('sms/http-sms-gateway')->with([
                'message' => language_data('Gateway information not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // postManageSmsGateway Function Start Here
    //======================================================================
    public function postManageSmsGateway(Request $request)
    {
        $self = 'sms-gateways';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $cmd = Input::get('cmd');

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('sms/gateway-manage/' . $cmd)->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'schedule' => 'required', 'status' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/gateway-manage/' . $cmd)->withErrors($v->errors());
        }

        $gateway = SMSGateways::find($cmd);
        $gateway_name = $gateway->name;

        if ($gateway_name == 'Asterisk') {
            $amiSetting = "\n" .
                'AMI_HOST=' . $request->gateway_link . '
AMI_PORT=' . $request->extra_value . '
AMI_USERNAME=' . $request->gateway_user_name . '
AMI_SECRET=' . $request->gateway_password . '
AMI_DEVICE=' . $request->device_name . '
' . "\n";

            // @ignoreCodingStandard
            $env = file_get_contents(base_path('.env'));
            $rows = explode("\n", $env);
            $unwanted = "AMI_HOST|AMI_PORT|AMI_USERNAME|AMI_SECRET|AMI_DEVICE";
            $cleanArray = preg_grep("/$unwanted/i", $rows, PREG_GREP_INVERT);
            $cleanString = implode("\n", $cleanArray);
            $env = $cleanString . $amiSetting;

            try {
                file_put_contents(base_path('.env'), $env);
            } catch (\Exception $e) {
                return redirect('sms/gateway-manage/' . $cmd)->with([
                    'message' => $e->getMessage(),
                    'message_important' => true
                ]);
            }
        }

        if ($gateway->custom == 'Yes') {
            if ($gateway_name == '') {
                return redirect('sms/gateway-manage/' . $cmd)->with([
                    'message' => language_data('Gateway name required'),
                    'message_important' => true
                ]);
            }
        } else {
            $gateway_name = $gateway->name;
        }

        if ($gateway->name != $gateway_name) {
            $exist_gateway = SMSGateways::where('name', $gateway_name)->first();
            if ($exist_gateway) {
                return redirect('sms/gateway-manage/' . $cmd)->with([
                    'message' => language_data('Gateway already exist'),
                    'message_important' => true
                ]);
            }
        }

        if ($gateway->type == 'http') {
            $redirect_url = 'sms/http-sms-gateway';
        } else {
            $redirect_url = 'sms/smpp-sms-gateway';
        }

        $gateway->name = $gateway_name;
        $gateway->api_link = $request->gateway_link;
        $gateway->username = $request->gateway_user_name;
        $gateway->password = $request->gateway_password;
        $gateway->api_id = $request->extra_value;
        $gateway->schedule = $request->schedule;
        $gateway->status = $request->status;
        $gateway->save();

        return redirect($redirect_url)->with([
            'message' => language_data('Custom gateway updated successfully')
        ]);

    }

    //======================================================================
    // deleteSmsGateway Function Start Here
    //======================================================================
    public function deleteSmsGateway($id)
    {
        $self = 'sms-gateways';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $gateway = SMSGateways::find($id);
        if ($gateway && $gateway->custom == 'Yes') {
            $client = Client::where('sms_gateway', $id)->first();
            if ($client) {
                return redirect('sms/http-sms-gateway')->with([
                    'message' => language_data('Client are registered with this gateway'),
                    'message_important' => true
                ]);
            }

            CustomSMSGateways::where('gateway_id', $id)->delete();
            $gateway->delete();

            return redirect('sms/http-sms-gateway')->with([
                'message' => language_data('Gateway deleted successfully'),
            ]);

        } else {
            return redirect('sms/http-sms-gateway')->with([
                'message' => language_data('Delete option disable for this gateway'),
                'message_important' => true
            ]);
        }
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
    // sendBulkSMS Function Start Here
    //======================================================================
    public function sendBulkSMS()
    {
        $self = 'send-bulk-sms';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $client_group = ClientGroups::where('status', 'Yes')->get();
        $phone_book = ImportPhoneNumber::where('user_id', 0)->get();
        $gateways = SMSGateways::where('status', 'Active')->get();
        $sms_templates = SMSTemplates::where('status', 'active')->where('cl_id', '0')->get();
        $schedule_sms = false;

        return view('admin.send-bulk-sms', compact('client_group', 'gateways', 'sms_templates', 'phone_book', 'schedule_sms'));

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
                'sms_gateway' => 'required', 'message' => 'required', 'schedule_time' => 'required', 'message_type' => 'required', 'remove_duplicate' => 'required'
            ]);

            $redirect_url = 'sms/send-schedule-sms';
        } else {
            $v = \Validator::make($request->all(), [
                'sms_gateway' => 'required', 'message' => 'required', 'message_type' => 'required', 'remove_duplicate' => 'required'
            ]);

            $redirect_url = 'sms/send-sms';
        }


        if ($v->fails()) {
            return redirect($redirect_url)->withErrors($v->errors());
        }


        $gateway = SMSGateways::find($request->sms_gateway);
        if ($gateway->status != 'Active') {
            return redirect($redirect_url)->with([
                'message' => language_data('SMS gateway not active'),
                'message_important' => true
            ]);
        }

        if ($gateway->custom == 'Yes') {
            $cg_info = CustomSMSGateways::where('gateway_id', $request->sms_gateway)->first();
        } else {
            $cg_info = '';
        }

        $sender_id = $request->sender_id;
        $message = $request->message;
        $msg_type = $request->message_type;

        $results = [];

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

            if (count($results) >= 0) {

                $filtered_data = [];
                $blacklist = BlackListContact::where('user_id', 0)->select('numbers')->get()->toArray();

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

                            $clphone = str_replace(['(', ')', '+', '-', ' '], '', $r['phone_number']);

                            ScheduleSMS::create([
                                'userid' => 0,
                                'sender' => $sender_id,
                                'receiver' => $clphone,
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

                            $clphone = str_replace(['(', ')', '+', '-', ' '], '', $r['phone_number']);

                            array_push($final_insert_data, [
                                'phone_number' => $clphone,
                                'message' => $get_message,
                                'segments' => $msgcount
                            ]);
                        }
                    }


                    $final_data = json_encode($final_insert_data, true);

                    StoreBulkSMS::create([
                        'userid' => 0,
                        'sender' => $sender_id,
                        'msg_data' => $final_data,
                        'status' => 0,
                        'type' => $msg_type,
                        'use_gateway' => $gateway->id
                    ]);

                }

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
    // sendBulkSMSFile Function Start Here
    //======================================================================
    public function sendBulkSMSFile()
    {
        $self = 'send-sms-from-file';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $gateways = SMSGateways::where('status', 'Active')->get();
        $sms_templates = SMSTemplates::where('status', 'active')->where('cl_id', '0')->get();
        $schedule_sms = false;

        return view('admin.send-sms-file', compact('gateways', 'sms_templates', 'schedule_sms'));

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
            return redirect('sms/send-sms-file')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $self = 'send-sms-from-file';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        if (function_exists('ini_set') && ini_get('max_execution_time')) {
            ini_set('max_execution_time', '-1');
        }


        if ($request->schedule_sms_status) {
            $v = \Validator::make($request->all(), [
                'import_numbers' => 'required', 'sms_gateway' => 'required', 'message' => 'required', 'schedule_time' => 'required', 'message_type' => 'required', 'remove_duplicate' => 'required'
            ]);

            $redirect_url = 'sms/send-schedule-sms-file';
        } else {
            $v = \Validator::make($request->all(), [
                'import_numbers' => 'required', 'sms_gateway' => 'required', 'message' => 'required', 'message_type' => 'required', 'remove_duplicate' => 'required'
            ]);

            $redirect_url = 'sms/send-sms-file';
        }


        if ($v->fails()) {
            return redirect($redirect_url)->withErrors($v->errors());
        }

        $gateway = SMSGateways::find($request->sms_gateway);
        if ($gateway->status != 'Active') {
            return redirect($redirect_url)->with([
                'message' => language_data('SMS gateway not active'),
                'message_important' => true
            ]);
        }

        $file_extension = Input::file('import_numbers')->getClientOriginalExtension();

        $supportedExt = array('csv', 'xls', 'xlsx');

        if (!in_array_r($file_extension, $supportedExt)) {
            return redirect($redirect_url)->with([
                'message' => language_data('Insert Valid Excel or CSV file'),
                'message_important' => true
            ]);
        }

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

        $valid_phone_numbers = [];
        $get_data = [];
        $final_insert_data = [];

        $blacklist = BlackListContact::where('user_id', 0)->select('numbers')->get()->toArray();

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

        $message = $request->message;
        $sender_id = $request->sender_id;
        $msg_type = $request->message_type;

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

                $clphone = str_replace(['(', ')', '+', '-', ' '], '', $msg_data[$number_column]);

                ScheduleSMS::create([
                    'userid' => 0,
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


                $clphone = str_replace(['(', ')', '+', '-', ' '], '', $msg_data[$number_column]);

                array_push($final_insert_data, [
                    'phone_number' => $clphone,
                    'message' => $get_message,
                    'segments' => $msgcount
                ]);

            }

            $results = json_encode($final_insert_data, true);


            StoreBulkSMS::create([
                'userid' => 0,
                'sender' => $sender_id,
                'msg_data' => $results,
                'status' => 0,
                'type' => $msg_type,
                'use_gateway' => $gateway->id
            ]);
        }

        return redirect($redirect_url)->with([
            'message' => language_data('SMS added in queue and will deliver one by one')
        ]);

    }


    //======================================================================
    // sendScheduleSMS Function Start Here
    //======================================================================
    public function sendScheduleSMS()
    {

        $self = 'send-schedule-sms';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $client_group = ClientGroups::where('status', 'Yes')->get();
        $phone_book = ImportPhoneNumber::where('user_id', 0)->get();
        $gateways = SMSGateways::where('status', 'Active')->where('schedule', 'Yes')->get();
        $sms_templates = SMSTemplates::where('status', 'active')->where('cl_id', '0')->get();
        $schedule_sms = true;

        return view('admin.send-bulk-sms', compact('client_group', 'gateways', 'sms_templates', 'phone_book', 'schedule_sms'));
    }


    //======================================================================
    // postUpdateScheduleSMS Function Start Here
    //======================================================================
    public function postUpdateScheduleSMS(Request $request)
    {

        $self = 'send-schedule-sms';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'phone_number' => 'required', 'sms_gateway' => 'required', 'message' => 'required', 'schedule_time' => 'required', 'message_type' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/manage-update-schedule-sms/' . $request->cmd)->withErrors($v->errors());
        }

        $gateway = SMSGateways::find($request->sms_gateway);
        if ($gateway->status != 'Active') {
            return redirect('sms/send-single-schedule-sms')->with([
                'message' => language_data('SMS gateway not active'),
                'message_important' => true
            ]);
        }
        $schedule_time = date('Y-m-d H:i:s', strtotime($request->schedule_time));

        $message = $request->message;
        $msg_type = $request->message_type;

        if ($msg_type != 'plain' && $msg_type != 'unicode') {
            return redirect('sms/manage-update-schedule-sms/' . $request->cmd)->with([
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
        $gateway_id = $gateway->id;

        $blacklist = BlackListContact::where('user_id', 0)->select('numbers')->get()->toArray();

        if ($blacklist && is_array($blacklist) && count($blacklist) > 0) {
            $blacklist = array_column($blacklist, 'numbers');
        }

        if (in_array($request->phone_number, $blacklist)) {
            return redirect('sms/manage-update-schedule-sms/' . $request->cmd)->with([
                'message' => 'Phone number contain in blacklist',
                'message_important' => true
            ]);
        }

        $clphone = str_replace(['(', ')', '+', '-', ' '], '', $request->phone_number);

        ScheduleSMS::where('id', $request->cmd)->update([
            'sender' => $sender_id,
            'receiver' => $clphone,
            'amount' => $msgcount,
            'message' => $message,
            'type' => $msg_type,
            'submit_time' => $schedule_time,
            'use_gateway' => $gateway_id
        ]);

        return redirect('sms/update-schedule-sms')->with([
            'message' => language_data('SMS are scheduled. Deliver in correct time')
        ]);

    }

    //======================================================================
    // sendScheduleSMSFile Function Start Here
    //======================================================================
    public function sendScheduleSMSFile()
    {

        $self = 'schedule-sms-from-file';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $gateways = SMSGateways::where('status', 'Active')->where('schedule', 'Yes')->get();
        $sms_templates = SMSTemplates::where('status', 'active')->where('cl_id', '0')->get();
        $schedule_sms = true;

        return view('admin.send-sms-file', compact('gateways', 'sms_templates', 'schedule_sms'));
    }


    //======================================================================
    // updateScheduleSMS Function Start Here
    //======================================================================
    public function updateScheduleSMS()
    {
        $self = 'send-schedule-sms';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $sms_history = ScheduleSMS::all();
        return view('admin.update-schedule-sms', compact('sms_history', 'gateways'));
    }

    //======================================================================
    // manageUpdateScheduleSMS Function Start Here
    //======================================================================
    public function manageUpdateScheduleSMS($id)
    {
        $sh = ScheduleSMS::find($id);

        if ($sh) {
            $gateways = SMSGateways::where('status', 'Active')->where('schedule', 'Yes')->get();
            return view('admin.manage-update-schedule-sms', compact('gateways', 'sh'));
        } else {
            return redirect('sms/update-schedule-sms')->with([
                'message' => language_data('Please try again'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // deleteScheduleSMS Function Start Here
    //======================================================================
    public function deleteScheduleSMS($id)
    {
        $sh = ScheduleSMS::find($id);
        if ($sh) {
            $sh->delete();
            return redirect('sms/update-schedule-sms')->with([
                'message' => language_data('SMS info deleted successfully')
            ]);
        } else {
            return redirect('sms/update-schedule-sms')->with([
                'message' => language_data('Please try again'),
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // smsTemplates Function Start Here
    //======================================================================
    public function smsTemplates()
    {

        $self = 'sms-templates';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $sms_templates = SMSTemplates::where('cl_id', '0')->orWhere('global', 'yes')->get();
        return view('admin.sms-templates', compact('sms_templates'));
    }

    //======================================================================
    // createSmsTemplate Function Start Here
    //======================================================================
    public function createSmsTemplate()
    {

        $self = 'sms-templates';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        return view('admin.create-sms-template');
    }

    //======================================================================
    // postSmsTemplate Function Start Here
    //======================================================================
    public function postSmsTemplate(Request $request)
    {

        $self = 'sms-templates';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'template_name' => 'required', 'message' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/create-sms-template')->withErrors($v->errors());
        }


        if ($request->set_global == 'yes') {
            $exist = SMSTemplates::where('template_name', $request->template_name)->where('global', 'yes')->first();
            $global = 'yes';
        } else {
            $exist = SMSTemplates::where('template_name', $request->template_name)->where('cl_id', 0)->where('global', 'no')->first();
            $global = 'no';
        }

        if ($exist) {
            return redirect('sms/create-sms-template')->with([
                'message' => language_data('Template already exist'),
                'message_important' => true
            ]);
        }


        $st = new SMSTemplates();
        $st->cl_id = '0';
        $st->template_name = $request->template_name;
        $st->from = $request->from;
        $st->message = $request->message;
        $st->global = $global;
        $st->status = 'active';
        $st->save();

        return redirect('sms/sms-templates')->with([
            'message' => language_data('Sms template created successfully')
        ]);

    }

    //======================================================================
    // manageSmsTemplate Function Start Here
    //======================================================================
    public function manageSmsTemplate($id)
    {

        $self = 'sms-templates';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $st = SMSTemplates::find($id);

        if ($st) {

            return view('admin.manage-sms-template', compact('st'));

        } else {
            return redirect('sms/sms-templates')->with([
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

        $self = 'sms-templates';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $cmd = Input::get('cmd');

        $v = \Validator::make($request->all(), [
            'template_name' => 'required', 'message' => 'required', 'status' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/manage-sms-template/' . $cmd)->withErrors($v->errors());
        }

        $st = SMSTemplates::find($cmd);

        if ($st) {
            if ($st->template_name != $request->template_name) {

                if ($request->set_global == 'yes') {
                    $exist = SMSTemplates::where('template_name', $request->template_name)->where('global', 'yes')->first();
                } else {
                    $exist = SMSTemplates::where('template_name', $request->template_name)->where('cl_id', 0)->where('global', 'no')->first();
                }

                if ($exist) {
                    return redirect('sms/manage-sms-template/' . $cmd)->with([
                        'message' => language_data('Template already exist'),
                        'message_important' => true
                    ]);
                }
            }
            if ($request->set_global == 'yes') {
                $global = 'yes';
            } else {
                $global = 'no';
            }

            $st->template_name = $request->template_name;
            $st->from = $request->from;
            $st->message = $request->message;
            $st->status = $request->status;
            $st->global = $global;
            $st->save();

            return redirect('sms/sms-templates')->with([
                'message' => language_data('Sms template updated successfully')
            ]);

        } else {
            return redirect('sms/sms-templates')->with([
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

        $self = 'sms-templates';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $st = SMSTemplates::find($id);
        if ($st) {
            $st->delete();

            return redirect('sms/sms-templates')->with([
                'message' => language_data('Sms template delete successfully')
            ]);

        } else {
            return redirect('sms/sms-templates')->with([
                'message' => language_data('Sms template not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // apiInfo Function Start Here
    //======================================================================
    public function apiInfo()
    {

        $self = 'sms-api';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $gateways = SMSGateways::where('status', 'Active')->get();
        return view('admin.sms-api-info', compact('gateways'));
    }

    //======================================================================
    // updateApiInfo Function Start Here
    //======================================================================
    public function updateApiInfo(Request $request)
    {

        $self = 'sms-api';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $v = \Validator::make($request->all(), [
            'api_url' => 'required', 'api_key' => 'required', 'sms_gateway' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms-api/info')->withErrors($v->errors());
        }

        if ($request->api_url != '') {
            AppConfig::where('setting', '=', 'api_url')->update(['value' => $request->api_url]);
        }

        if ($request->api_key != '') {
            AppConfig::where('setting', '=', 'api_key')->update(['value' => $request->api_key]);
        }

        if ($request->sms_gateway != '') {
            AppConfig::where('setting', '=', 'sms_api_gateway')->update(['value' => $request->sms_gateway]);
        }

        return redirect('sms-api/info')->with([
            'message' => language_data('API information updated successfully')
        ]);

    }


    /*Version 1.3*/

    //======================================================================
    // priceBundles Function Start Here
    //======================================================================
    public function priceBundles()
    {
        $bundles = SMSBundles::all();
        return view('admin.sms-bundles', compact('bundles'));
    }

    //======================================================================
    // postPriceBundles Function Start Here
    //======================================================================
    public function postPriceBundles(Request $request)
    {

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('sms/price-bundles')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'unit_from' => 'required', 'unit_to' => 'required', 'price' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/price-bundles')->withErrors($v->errors());
        }

        $unit_from = Input::get('unit_from');
        $unit_to = Input::get('unit_to');
        $price = Input::get('price');
        $trans_fee = Input::get('trans_fee');

        SMSBundles::truncate();

        $i = 0;
        foreach ($unit_from as $uf) {
            $sb = new SMSBundles();
            $sb->unit_from = $uf;
            $sb->unit_to = $unit_to[$i];
            $sb->price = $price[$i];
            $sb->trans_fee = $trans_fee[$i];
            $sb->save();
            $i++;
        }

        return redirect('sms/price-bundles')->with([
            'message' => language_data('Price Bundles Update Successfully')
        ]);

    }


    /*Version 2.0*/

    //======================================================================
    // blacklistContacts Function Start Here
    //======================================================================
    public function blacklistContacts()
    {
        return view('admin.blacklist-contacts');
    }

    //======================================================================
    // getBlacklistContacts Function Start Here
    //======================================================================
    public function getBlacklistContacts()
    {
        $blacklist = BlackListContact::select(['id', 'numbers'])->where('user_id', 0)->get();
        return Datatables::of($blacklist)
            ->addColumn('action', function ($bl) {
                return '
            <a href="#" class="btn btn-danger btn-xs cdelete" id="' . $bl->id . '"><i class="fa fa-trash"></i> ' . language_data("Delete") . '</a>';
            })
            ->escapeColumns([])
            ->make(true);
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
            return redirect('sms/blacklist-contacts')->withErrors($v->errors());
        }

        $number = str_replace(['(', ')', '+', '-', ' '], '', $request->phone_number);

        $exist = BlackListContact::where('numbers', $number)->where('user_id', 0)->first();

        if ($exist) {
            return redirect('sms/blacklist-contacts')->with([
                'message' => 'Contact already exist',
                'message_important' => true
            ]);
        }

        BlackListContact::create([
            'user_id' => '0',
            'numbers' => $number
        ]);

        return redirect('sms/blacklist-contacts')->with([
            'message' => 'Number added on blacklist',
        ]);

    }

    //======================================================================
    // deleteBlacklistContact Function Start Here
    //======================================================================
    public function deleteBlacklistContact($id)
    {
        $blacklist = BlackListContact::where('user_id', '0')->find($id);
        if ($blacklist) {
            $blacklist->delete();
            return redirect('sms/blacklist-contacts')->with([
                'message' => 'Number deleted from blacklist',
            ]);
        } else {
            return redirect('sms/blacklist-contacts')->with([
                'message' => 'Number not found on blacklist',
                'message_important' => true
            ]);
        }
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
    // Version 2.2
    //======================================================================

    //======================================================================
    // sdkInfo Function Start Here
    //======================================================================
    public function sdkInfo()
    {
        return view('admin.sms-sdk-info');
    }

    //======================================================================
    // sendQuickSMS Function Start Here
    //======================================================================
    public function sendQuickSMS()
    {

        $self = 'send-bulk-sms';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $gateways = SMSGateways::where('status', 'Active')->get();

        return view('admin.send-quick-sms', compact('gateways'));
    }


    //======================================================================
    // postQuickSMS Function Start Here
    //======================================================================
    public function postQuickSMS(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'sms_gateway' => 'required', 'recipients' => 'required', 'message' => 'required', 'message_type' => 'required', 'remove_duplicate' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sms/quick-sms')->withErrors($v->errors());
        }

        try {

            $recipients = explode(',', $request->recipients);
            $results = array_filter($recipients);

            if (is_array($results) && count($results) <= 100) {

                $gateway = SMSGateways::find($request->sms_gateway);
                if ($gateway->status != 'Active') {
                    return redirect('sms/quick-sms')->with([
                        'message' => language_data('SMS gateway not active'),
                        'message_important' => true
                    ]);
                }

                if ($gateway->custom == 'Yes') {
                    $cg_info = CustomSMSGateways::where('gateway_id', $request->sms_gateway)->first();
                } else {
                    $cg_info = '';
                }

                $message = $request->message;
                $sender_id = $request->sender_id;
                $msg_type = $request->message_type;

                if ($msg_type != 'plain' && $msg_type != 'unicode') {
                    return redirect('sms/quick-sms')->with([
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

                $filtered_data = [];
                $blacklist = BlackListContact::select('numbers')->get()->toArray();

                if ($blacklist && is_array($blacklist) && count($blacklist)>0){

                    $blacklist = array_column($blacklist,'numbers');

                    array_filter($results, function ($element) use ($blacklist,&$filtered_data) {
                        if (!in_array(trim($element),$blacklist)){
                            array_push($filtered_data, $element);
                        }
                    });

                    $results = array_values($filtered_data);
                }

                if (count($results) <= 0){
                    return redirect('sms/quick-sms')->with([
                        'message' => 'Recipient empty',
                        'message_important' => true
                    ]);
                }

                if ($request->remove_duplicate == 'yes'){
                    $results = array_unique($results, SORT_REGULAR);
                }

                $results = array_values($results);

                foreach ($results as $r) {
                    $number = str_replace(['(', ')', '+', '-', ' '], '', trim($r));
                    $this->dispatch(new SendBulkSMS('0', $number, $gateway, $sender_id, $message, $msgcount, $cg_info,'',$msg_type));
                }

                return redirect('sms/quick-sms')->with([
                    'message' => 'Please check sms history for status'
                ]);
            } else {
                return redirect('sms/quick-sms')->with([
                    'message' => 'You can not send more than 100 sms using quick sms option',
                    'message_important' => true
                ]);
            }
            
        } catch (\Exception $e) {
            return redirect('sms/quick-sms')->with([
                'message' => $e->getMessage(),
                'message_important' => true
            ]);
        }

    }


}
