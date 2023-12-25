<?php

namespace App\Http\Controllers;

use App\ContactList;
use App\ImportPhoneNumber;
use App\SMSHistory;
use App\SMSInbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Exceptions\LaravelExcelException;
use Maatwebsite\Excel\Facades\Excel;

class CommonDataController extends Controller
{

    //======================================================================
    // getCsvFileInfo Function Start Here
    //======================================================================
    public function getCsvFileInfo(Request $request)
    {

        try{

            $file_extension = Input::file('import_numbers')->getClientOriginalExtension();
            $supportedExt = array('csv', 'xls', 'xlsx');

            if (!in_array_r($file_extension, $supportedExt)) {
                return response()->json(['status' => 'error', 'message' => language_data('Insert Valid Excel or CSV file')]);
            }
            
            $all_data = Excel::load($request->import_numbers)->noHeading()->all()->toArray();

            if ($all_data && is_array($all_data) && array_empty($all_data)) {
                return response()->json(['status' => 'error', 'message' => 'Empty Field']);
            }

            $counter = "A";

            if ($request->header_exist == 'true') {

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


            return response()->json(["status" => "success", "data" => $all_data]);

        }catch (LaravelExcelException $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }

    }


    //======================================================================
    // customUpdate Function Start Here
    //======================================================================
    public function customUpdate()
    {
        $sms_history = SMSHistory::all();
        foreach ($sms_history as $history){
            $get_inbox = SMSInbox::where('msg_id',$history->id)->first();
            if ($get_inbox){
                $history->message = $get_inbox->original_msg;
                $history->status = $get_inbox->status;
                $history->amount = $get_inbox->amount;
                $history->save();
            }
        }
//
//        $import_contact = ImportPhoneNumber::all();
//
//        foreach ($import_contact as $contact){
//            $contact_list = $contact->numbers;
//            $contact_list = json_decode($contact_list);
//            foreach ($contact_list as $list){
//                ContactList::create([
//                    'pid' => $contact->id,
//                    'phone_number' => $list->phone_number,
//                    'email_address' => $list->email_address,
//                    'user_name' => $list->user_name,
//                    'company' => $list->company,
//                    'first_name' => $list->first_name,
//                    'last_name' => $list->last_name,
//                ]);
//            }
//
//        }
//
    }

}
