<?php

namespace App\Http\Controllers;

use App\Classes\Permission;
use App\Client;
use App\SMSHistory;
use App\SMSInbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;

class ReportsController extends Controller
{

    /**
     * ReportsController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    //======================================================================
    // smsHistory Function Start Here
    //======================================================================
    public function smsHistory()
    {

        $self = 'sms-history';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }
        return view('admin.sms-history');
    }

    //======================================================================
    // smsViewInbox Function Start Here
    //======================================================================
    public function smsViewInbox($id)
    {

        $self = 'sms-history';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $inbox_info = SMSHistory::find($id);

        if ($inbox_info) {
            return view('admin.sms-inbox', compact('inbox_info'));
        } else {
            return redirect('sms/history')->with([
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

        $self = 'sms-history';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $inbox_info = SMSHistory::find($id);

        if ($inbox_info) {
            $inbox_info->delete();
            return redirect('sms/history')->with([
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

        $sms_history = SMSHistory::select(['id', 'sender', 'receiver', 'amount', 'status', 'send_by', 'updated_at'])->orderBy($get_search_column, $short_by);
        return Datatables::of($sms_history)
            ->addColumn('action', function ($sms) {
                return '
                <a class="btn btn-success btn-xs" href="' . url("sms/view-inbox/$sms->id") . '" ><i class="fa fa-inbox"></i>' . language_data('Inbox') . '</a>
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

                if ($request->has('send_by') && $request->get('send_by') !='0') {
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
                }elseif($sms->send_by == 'api'){
                    return '<span class="text-success"> API SMS </span>';
                } else {
                    return '<span class="text-success"> ' . language_data('Incoming') . ' </span>';
                }
            })
            ->escapeColumns([])
            ->make(true);


    }

    //======================================================================
    // bulkDeleteSMS Function Start Here
    //======================================================================
    public function bulkDeleteSMS(Request $request)
    {

        if ($request->has('data_ids')){
            $all_ids = explode(',',$request->get('data_ids'));

            if (is_array($all_ids) && count($all_ids) >0){
                SMSHistory::destroy($all_ids);
            }
        }

    }


}
