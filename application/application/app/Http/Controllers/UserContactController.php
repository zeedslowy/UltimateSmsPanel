<?php

namespace App\Http\Controllers;

use App\BlackListContact;
use App\ContactList;
use App\ImportPhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class UserContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('client');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     */
    public function phoneBook()
    {
        $clientGroups = ImportPhoneNumber::where('user_id', Auth::guard('client')->user()->id)->get();
        return view('client.phone-book', compact('clientGroups'));
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postPhoneBook(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'list_name' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/phone-book')->withErrors($v->errors());
        }

        $exist = ImportPhoneNumber::where('group_name', $request->list_name)->where('user_id', Auth::guard('client')->user()->id)->first();

        if ($exist) {
            return redirect('user/phone-book')->with([
                'message' => 'List name already exist',
                'message_important' => true
            ]);
        }

        $phone_book = new ImportPhoneNumber();
        $phone_book->user_id = Auth::guard('client')->user()->id;
        $phone_book->group_name = $request->list_name;

        $phone_book->save();

        return redirect('user/phone-book')->with([
            'message' => 'List added successfully'
        ]);
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updatePhoneBook(Request $request)
    {
        $v = \Validator::make($request->all(), [
            'list_name' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/phone-book')->withErrors($v->errors());
        }

        $cmd = $request->cmd;

        $phone_book = ImportPhoneNumber::find($cmd);

        if ($phone_book == '') {
            return redirect('user/phone-book')->with([
                'message' => 'Contact list not found',
                'message_important' => true
            ]);
        }

        if ($phone_book->group_name != $request->list_name) {

            $exist = ImportPhoneNumber::where('group_name', $request->list_name)->where('user_id', Auth::guard('client')->user()->id)->first();

            if ($exist) {
                return redirect('user/phone-book')->with([
                    'message' => 'List name already exist',
                    'message_important' => true
                ]);
            }
        }

        $phone_book->group_name = $request->list_name;
        $phone_book->save();

        return redirect('user/phone-book')->with([
            'message' => 'List updated successfully'
        ]);
    }


    public function viewContact($id)
    {
        $exist = ImportPhoneNumber::where('user_id', Auth::guard('client')->user()->id)->find($id);

        if ($exist) {
            return view('client.view-contact', compact('id'));

        } else {
            return redirect('user/phone-book')->with([
                'message' => 'Invalid Phone book',
                'message_important' => true
            ]);
        }

    }


    public function deleteContact($id)
    {

        $contact = ContactList::find($id);

        if ($contact) {

            $exist = ImportPhoneNumber::where('user_id', Auth::guard('client')->user()->id)->find($contact->pid);

            if ($exist) {
                $pid = $contact->pid;
                $contact->delete();

                return redirect('user/view-contact/' . $pid)->with([
                    'message' => 'Contact deleted successfully'
                ]);

            } else {
                return redirect('user/phone-book')->with([
                    'message' => 'Invalid Phone book',
                    'message_important' => true
                ]);
            }


        } else {

            return redirect('user/phone-book')->with([
                'message' => 'Contact info not found',
                'message_important' => true
            ]);
        }

    }

    //======================================================================
    // importContacts Function Start Here
    //======================================================================
    public function importContacts()
    {

        $phone_book = ImportPhoneNumber::where('user_id', Auth::guard('client')->user()->id)->get();
        return view('client.import-contact', compact('phone_book'));

    }

    //======================================================================
    // downloadContactSampleFile Function Start Here
    //======================================================================
    public function downloadContactSampleFile()
    {
        return response()->download('assets/test_file/sms.csv');
    }

    //======================================================================
    // postImportContact Function Start Here
    //======================================================================
    public function postImportContact(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('user/sms/import-contacts')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        if (function_exists('ini_set') && ini_get('max_execution_time')) {
            ini_set('max_execution_time', '-1');
        }


        $v = \Validator::make($request->all(), [
            'import_numbers' => 'required', 'group_name' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/sms/import-contacts')->withErrors($v->errors());
        }

        $file_extension = Input::file('import_numbers')->getClientOriginalExtension();

        $supportedExt = array('csv', 'xls', 'xlsx');

        if (!in_array_r($file_extension, $supportedExt)) {
            return redirect('user/sms/import-contacts')->with([
                'message' => language_data('Insert Valid Excel or CSV file'),
                'message_important' => true
            ]);
        }


        $all_data = Excel::load($request->import_numbers)->noHeading()->all()->toArray();


        if ($all_data && is_array($all_data) && array_empty($all_data)) {
            return redirect('user/sms/import-contacts')->with([
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

        $blacklist = BlackListContact::select('numbers')->get()->toArray();

        if ($blacklist && is_array($blacklist) && count($blacklist)>0){
            $blacklist = array_column($blacklist,'numbers');
        }


        $number_column = $request->number_column;
        $email_address_column = $request->email_address_column;
        $user_name_column = $request->user_name_column;
        $company_column = $request->company_column;
        $first_name_column = $request->first_name_column;
        $last_name_column = $request->last_name_column;

        array_filter($all_data, function ($data) use ($number_column, $email_address_column,$user_name_column,$company_column,$first_name_column,$last_name_column,&$get_data, &$valid_phone_numbers,$blacklist) {

            if ($data[$number_column]) {
                if (preg_match('/^\(?\+?([0-9]{1,4})\)?[-\. ]?(\d{3})[-\. ]?([0-9]{7})$/', trim($data[$number_column]))) {
                    if (!in_array($data[$number_column],$blacklist)){
                        array_push($valid_phone_numbers, $data[$number_column]);
                        array_push($get_data, [
                            'phone_number' => $data[$number_column],
                            'email_address' => $data[$email_address_column],
                            'user_name' => $data[$user_name_column],
                            'company' => $data[$company_column],
                            'first_name' => $data[$first_name_column],
                            'last_name' => $data[$last_name_column],
                        ]);
                    }
                }
            }
        });

        if (is_array($valid_phone_numbers) && count($valid_phone_numbers) <= 0) {
            return redirect('user/sms/import-contacts')->with([
                'message' => 'Invalid phone numbers',
                'message_important' => true
            ]);
        }



        foreach ($get_data as $r){

            $data = array_values($r);

            $contact = new ContactList();
            $contact->pid = $request->group_name;
            $contact->phone_number = $data['0'];
            $contact->email_address = $data['1'];
            $contact->user_name = $data['2'];
            $contact->company = $data['3'];
            $contact->first_name = $data['4'];
            $contact->last_name = $data['5'];
            $contact->save();

        }

        return redirect('user/sms/import-contacts')->with([
            'message' => 'Phone number imported successfully'
        ]);
    }

    //======================================================================
    // postMultipleContact Function Start Here
    //======================================================================
    public function postMultipleContact(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('user/sms/import-contacts')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), [
            'import_numbers' => 'required', 'group_name' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/sms/import-contacts')->withErrors($v->errors());
        }

        $results = $request->import_numbers;
        try{
            $results = explode(',',$results);
            $results = array_filter($results);

            foreach ($results as $r){
                $contact = new ContactList();
                $contact->pid = $request->group_name;
                $contact->phone_number =trim($r);
                $contact->save();
            }

            return redirect('user/sms/import-contacts')->with([
                'message' => 'Phone number imported successfully'
            ]);
        }catch (\Exception $e){
            return redirect('user/sms/import-contacts')->with([
                'message' => $e->getMessage(),
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // deleteImportPhoneNumber Function Start Here
    //======================================================================
    public function deleteImportPhoneNumber($id)
    {

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('user/phone-book')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $clientGroup = ImportPhoneNumber::where('user_id', Auth::guard('client')->user()->id)->find($id);

        if ($clientGroup) {
            ContactList::where('pid', $id)->delete();
            $clientGroup->delete();

            return redirect('user/phone-book')->with([
                'message' => language_data('Client group deleted successfully')
            ]);

        } else {
            return redirect('user/phone-book')->with([
                'message' => language_data('Client Group not found'),
                'message_important' => true
            ]);
        }
    }


    public function addContact($id)
    {

        $exist = ImportPhoneNumber::where('user_id', Auth::guard('client')->user()->id)->find($id);

        if ($exist) {
            $contact_list = ContactList::where('pid', $id)->get();
            return view('client.add-contact', compact('contact_list', 'id'));
        } else {
            return redirect('user/phone-book')->with([
                'message' => 'Invalid Phone book',
                'message_important' => true
            ]);
        }

    }


    public function postNewContact(Request $request)
    {

        $cmd = $request->cmd;
        $v = \Validator::make($request->all(), [
            'number' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('user/add-contact/' . $cmd)->withErrors($v->errors());
        }


        $exist = ContactList::where('phone_number', $request->number)->where('pid', $cmd)->first();
        if ($exist) {
            return redirect('user/add-contact/' . $cmd)->with([
                'message' => 'Contact number already exist',
                'message_important' => true
            ]);
        }

        $contact = new ContactList();
        $contact->pid = $cmd;
        $contact->phone_number = $request->number;
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->email_address = $request->email;
        $contact->user_name = $request->username;
        $contact->company = $request->company;
        $contact->save();

        return redirect('user/view-contact/' . $cmd)->with([
            'message' => 'Contact added successfully'
        ]);

    }


    public function postSingleContact(Request $request)
    {

        $cmd = $request->cmd;

        $contact = ContactList::find($cmd);

        if ($contact) {

            $v = \Validator::make($request->all(), [
                'number' => 'required'
            ]);

            if ($v->fails()) {
                return redirect('user/view-contact/' . $contact->pid)->withErrors($v->errors());
            }

            if ($request->number != $contact->phone_number) {
                $exist = ContactList::where('phone_number', $request->number)->where('pid', $contact->pid)->first();
                if ($exist) {
                    return redirect('user/view-contact/' . $contact->pid)->with([
                        'message' => 'Contact number already exist',
                        'message_important' => true
                    ]);
                }
            }

            $contact->phone_number = $request->number;
            $contact->first_name = $request->first_name;
            $contact->last_name = $request->last_name;
            $contact->email_address = $request->email;
            $contact->user_name = $request->username;
            $contact->company = $request->company;
            $contact->save();

            return redirect('user/view-contact/' . $contact->pid)->with([
                'message' => 'Contact updated successfully'
            ]);
        } else {
            return redirect('user/phone-book')->with([
                'message' => 'Contact info not found',
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // getAllContact Function Start Here
    //======================================================================
    public function getAllContact($id)
    {
        $contact_list = ContactList::select(['id', 'phone_number', 'first_name', 'email_address', 'user_name', 'company'])->where('pid',$id)->get();
        return Datatables::of($contact_list)
            ->addColumn('action', function ($cl) {
                return '
                <a class="btn btn-success btn-xs" href="' . url("user/edit-contact/$cl->id") . '" ><i class="fa fa-edit"></i>' . language_data('Edit') . '</a>
                <a href="#" class="btn btn-danger btn-xs cdelete" id="'.$cl->id.'"><i class="fa fa-trash"></i> '.language_data("Delete").'</a>';
            })
            ->addColumn('id', function ($cl) {
                return "<div class='coder-checkbox'>
                             <input type='checkbox'  class='deleteRow' value='$cl->id'/>
                                            <span class='co-check-ui'></span>
                                        </div>";

            })
            ->addColumn('phone_number', function ($cl) {
                return $cl->phone_number;
            })
            ->escapeColumns([])
            ->make(true);
    }

    //======================================================================
    // deleteBulkContact Function Start Here
    //======================================================================
    public function deleteBulkContact(Request $request)
    {
        if ($request->has('data_ids')){
            $all_ids = explode(',',$request->get('data_ids'));

            if (is_array($all_ids) && count($all_ids) >0){
                ContactList::destroy($all_ids);
            }
        }
    }

    public function editContact($id)
    {
        $cl = ContactList::find($id);

        if ($cl){
            return view('client.edit-contact',compact('cl'));
        }else{
            return redirect('user/phone-book')->with([
                'message' => 'Contact info not found',
                'message_important' => true
            ]);
        }
    }

}
