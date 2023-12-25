<?php

namespace App\Http\Controllers;

use App\Classes\Permission;
use App\Client;
use App\InvoiceItems;
use App\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function is_numeric_array($array)
    {

        if (is_array($array) && count($array) > 0) {

            foreach ($array as $a) {
                if (!is_numeric($a)) {
                    return false;
                }
            }
            return true;
        } else {
            return false;
        }

    }

    //======================================================================
    // allInvoices Function Start Here
    //======================================================================
    public function allInvoices()
    {
        $self = 'all-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $invoices = Invoices::all();
        return view('admin.all-invoices', compact('invoices'));
    }

    //======================================================================
    // recurringInvoices Function Start Here
    //======================================================================
    public function recurringInvoices()
    {
        $self = 'recurring-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $invoices = Invoices::where('recurring', '!=', '0')->get();
        return view('admin.all-invoices', compact('invoices'));
    }

    //======================================================================
    // addInvoice Function Start Here
    //======================================================================
    public function addInvoice()
    {
        $self = 'add-new-invoice';
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
        return view('admin.add-new-invoice', compact('clients'));
    }

    //======================================================================
    // postInvoice Function Start Here
    //======================================================================
    public function postInvoice(Request $request)
    {
        $self = 'add-new-invoice';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $v = \Validator::make($request->all(), ['client_id' => 'required', 'invoice_date' => 'required', 'invoice_type' => 'required']);
        if ($v->fails()) {
            return redirect('invoices/add')->withInput($request->all())->withErrors($v->errors());
        }
        $cid = Input::get('client_id');
        $notes = Input::get('notes');
        $amount = Input::get('amount');
        $idate = Input::get('invoice_date');
        $invoice_type = Input::get('invoice_type');

        $tax = Input::get('taxed');
        $discount = Input::get('discount');
        $description = Input::get('desc');


        if ($invoice_type == 'recurring') {
            $pdate = Input::get('paid_date_recurring');
        } else {
            $pdate = Input::get('paid_date');
            $ddate = Input::get('due_date');
        }

        $qty = Input::get('qty');
        $ltotal = Input::get('ltotal');

        if ($cid == '') {
            return redirect('invoices/add')->withInput($request->all())->with(array('message' => language_data('Select a Customer'), 'message_important' => true));
        }
        if ($idate == '') {
            return redirect('invoices/add')->withInput($request->all())->with(array('message' => language_data('Invoice Created date is required'), 'message_important' => true));
        }
        if ($pdate == '') {
            return redirect('invoices/add')->withInput($request->all())->with(array('message' => language_data('Invoice Paid date is required'), 'message_important' => true));
        }
        if ($amount == '') {
            return redirect('invoices/add')->withInput($request->all())->with(array('message' => language_data('At least one item is required'), 'message_important' => true));
        }

        if (!is_array($description) || count(array_filter($description)) <= 0) {
            return redirect('invoices/add')->withInput($request->all())->with(array(
                'message' => language_data('At least one item is required'),
                'message_important' => true
            ));
        }


        if (!is_array($amount) || count(array_filter($amount)) <= 0 || !$this->is_numeric_array($amount)) {
            return redirect('invoices/add')->withInput($request->all())->with(array(
                'message' => 'Amount required',
                'message_important' => true
            ));
        }

        if (!is_array($qty) || count(array_filter($qty)) <= 0 || !$this->is_numeric_array($qty)) {
            return redirect('invoices/add')->withInput($request->all())->with(array(
                'message' => 'Item quantity required',
                'message_important' => true
            ));
        }

        if (!is_array($qty) || count(array_filter($qty)) <= 0 || !$this->is_numeric_array($qty)) {
            return redirect('invoices/add')->withInput($request->all())->with(array(
                'message' => 'Item quantity required',
                'message_important' => true
            ));
        }


        if (!is_array($tax) || count(array_filter($tax)) != 0) {
            if (!$this->is_numeric_array($tax)) {
                return redirect('invoices/add')->withInput($request->all())->with(array(
                    'message' => 'Insert valid tax amount',
                    'message_important' => true
                ));
            }

        }
        if (!is_array($discount) || count(array_filter($discount)) != 0) {
            if (!$this->is_numeric_array($discount)) {
                return redirect('invoices/add')->withInput($request->all())->with(array(
                    'message' => 'Insert valid discount amount',
                    'message_important' => true
                ));
            }

        }


        $sTotal = '0';
        $i = '0';
        foreach ($amount as $samount) {
            $amount[$i] = $samount;
            $sTotal += $samount * ($qty[$i]);
            $i++;
        }
        $pTotal = '0';
        $x = '0';
        foreach ($ltotal as $lt) {
            $ltotal[$x] = $lt;
            $pTotal += $lt;
            $x++;
        }

        $nd = $pdate;

        if ($invoice_type == 'recurring') {

            $repeat = Input::get('repeat_type');
            $its = strtotime($idate);

            if ($repeat == 'week1') {
                $r = '+1 week';
                $nd = date('Y-m-d', strtotime('+1 week', $its));
            } elseif ($repeat == 'weeks2') {
                $r = '+2 weeks';
                $nd = date('Y-m-d', strtotime('+2 weeks', $its));
            } elseif ($repeat == 'month1') {
                $r = '+1 month';
                $nd = date('Y-m-d', strtotime('+1 month', $its));
            } elseif ($repeat == 'months2') {
                $r = '+2 months';
                $nd = date('Y-m-d', strtotime('+2 months', $its));
            } elseif ($repeat == 'months3') {
                $r = '+3 months';
                $nd = date('Y-m-d', strtotime('+3 months', $its));
            } elseif ($repeat == 'months6') {
                $r = '+6 months';
                $nd = date('Y-m-d', strtotime('+6 months', $its));
            } elseif ($repeat == 'year1') {
                $r = '+1 year';
                $nd = date('Y-m-d', strtotime('+1 year', $its));
            } elseif ($repeat == 'years2') {
                $r = '+2 years';
                $nd = date('Y-m-d', strtotime('+2 years', $its));
            } elseif ($repeat == 'years3') {
                $r = '+3 years';
                $nd = date('Y-m-d', strtotime('+3 years', $its));
            } else {
                return redirect('invoices/add')->withInput($request->all())->with(array('message' => language_data('Date Parsing Error'), 'message_important' => true));
            }
            $ddate = $nd;
            $bill_created = 'no';
        } else {
            $r = '0';
            $bill_created = 'yes';
        }

        if ($ddate == '') {
            return redirect('invoices/add')->withInput($request->all())->with(array('message' => language_data('Invoice Due date is required'), 'message_important' => true));
        }


        $cl = Client::find($cid);
        $cl_name = $cl['fname'] . ' ' . $cl['lname'];
        $cl_email = $cl->email;
        $inv = new Invoices();
        $inv->cl_id = $cid;
        $inv->client_name = $cl_name;
        $inv->created_by = Auth::user()->id;
        $inv->created = $idate;
        $inv->duedate = $ddate;
        $inv->datepaid = $nd;
        $inv->subtotal = $sTotal;
        $inv->total = $pTotal;
        $inv->status = 'Unpaid';
        $inv->pmethod = '';
        $inv->recurring = $r;
        $inv->bill_created = $bill_created;
        $inv->note = $notes;
        $inv->save();
        $inv_id = $inv->id;

        $i = '0';
        foreach ($description as $item) {
            $ltotal = ($amount[$i]) * ($qty[$i]);
            $ttotal = ($ltotal * $tax[$i]) / 100;
            $dtotal = ($ltotal * $discount[$i]) / 100;
            $fTotal = $ltotal + $ttotal - $dtotal;
            $d = new InvoiceItems();
            $d->inv_id = $inv_id;
            $d->cl_id = $cid;
            $d->item = $item;
            $d->qty = $qty[$i];
            $d->price = $amount[$i];
            $d->tax = $ttotal;
            $d->discount = $dtotal;
            $d->subtotal = $ltotal;
            $d->total = $fTotal;
            $d->save();
            $i++;
        }

        return redirect('invoices/view/' . $inv_id)->with(['message' => language_data('Invoice Created Successfully')]);
    }

    //======================================================================
    // viewInvoice Function Start Here
    //======================================================================
    public function viewInvoice($id)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $inv = Invoices::find($id);
        if ($inv) {
            $client = Client::where('status', 'Active')->find($inv->cl_id);
            $inv_items = InvoiceItems::where('inv_id', $id)->get();
            $tax_sum = InvoiceItems::where('inv_id', $id)->sum('tax');
            $dis_sum = InvoiceItems::where('inv_id', $id)->sum('discount');
            return view('admin.view-invoice', compact('client', 'inv', 'inv_items', 'tax_sum', 'dis_sum'));
        } else {
            return redirect('invoices/all')->with([
                'message' => language_data('Invoice not found'),
                'message_important' => true
            ]);
        }

    }

    //======================================================================
    // editInvoice Function Start Here
    //======================================================================
    public function editInvoice($id)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $inv = Invoices::find($id);
        if ($inv) {
            $client = Client::where('status', 'Active')->find($inv->cl_id);
            $inv_items = InvoiceItems::where('inv_id', $id)->get();
            return view('admin.edit-invoice', compact('client', 'inv', 'inv_items'));
        } else {
            return redirect('invoices/all')->with([
                'message' => language_data('Invoice not found'),
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // postEditInvoice Function Start Here
    //======================================================================
    public function postEditInvoice(Request $request)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $id = Input::get('cmd');

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('invoices/edit/' . $id)->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $v = \Validator::make($request->all(), ['invoice_date' => 'required', 'invoice_type' => 'required']);
        if ($v->fails()) {
            return redirect('invoices/edit/' . $id)->withErrors($v->errors());
        }
        $cid = Input::get('client_id');
        $notes = Input::get('notes');
        $amount = Input::get('amount');
        $idate = Input::get('invoice_date');
        $invoice_type = Input::get('invoice_type');

        if ($invoice_type == 'recurring') {
            $pdate = Input::get('paid_date_recurring');
        } else {
            $pdate = Input::get('paid_date');
            $ddate = Input::get('due_date');
        }

        $qty = Input::get('qty');
        $ltotal = Input::get('ltotal');

        $tax = Input::get('taxed');
        $discount = Input::get('discount');
        $description = Input::get('desc');


        if ($cid == '') {
            return redirect('invoices/edit/' . $id)->with(array('message' => language_data('Select a Customer'), 'message_important' => true));
        }
        if ($idate == '') {
            return redirect('invoices/edit/' . $id)->with(array('message' => language_data('Invoice Created date is required'), 'message_important' => true));
        }

        if ($pdate == '') {
            return redirect('invoices/edit/' . $id)->with(array('message' => language_data('Invoice Paid date is required'), 'message_important' => true));
        }
        if ($amount == '') {
            return redirect('invoices/edit/' . $id)->with(array('message' => language_data('At least one item is required'), 'message_important' => true));
        }


        if (!is_array($description) || count(array_filter($description)) <= 0){
            return redirect('invoices/edit/' . $id)->withInput($request->all())->with(array(
                'message' => language_data('At least one item is required'),
                'message_important' => true
            ));
        }


        if (!is_array($amount) || count(array_filter($amount)) <= 0 || !$this->is_numeric_array($amount)){
            return redirect('invoices/edit/' . $id)->withInput($request->all())->with(array(
                'message' => 'Amount required',
                'message_important' => true
            ));
        }

        if (!is_array($qty) || count(array_filter($qty)) <= 0 || !$this->is_numeric_array($qty)){
            return redirect('invoices/edit/' . $id)->withInput($request->all())->with(array(
                'message' => 'Item quantity required',
                'message_important' => true
            ));
        }

        if (!is_array($qty) || count(array_filter($qty)) <= 0 || !$this->is_numeric_array($qty)){
            return redirect('invoices/edit/' . $id)->withInput($request->all())->with(array(
                'message' => 'Item quantity required',
                'message_important' => true
            ));
        }


        if (!is_array($tax) || count(array_filter($tax)) != 0){
            if (!$this->is_numeric_array($tax)){
                return redirect('invoices/edit/' . $id)->withInput($request->all())->with(array(
                    'message' => 'Insert valid tax amount',
                    'message_important' => true
                ));
            }

        }
        if (!is_array($discount) || count(array_filter($discount)) != 0){
            if (!$this->is_numeric_array($discount)){
                return redirect('invoices/edit/' . $id)->withInput($request->all())->with(array(
                    'message' => 'Insert valid discount amount',
                    'message_important' => true
                ));
            }

        }



        $sTotal = '0';
        $i = '0';
        foreach ($amount as $samount) {
            $amount[$i] = $samount;
            $sTotal += $samount * ($qty[$i]);
            $i++;
        }
        $pTotal = '0';
        $x = '0';
        foreach ($ltotal as $lt) {
            $ltotal[$x] = $lt;
            $pTotal += $lt;
            $x++;
        }

        $nd = $pdate;

        if ($invoice_type == 'recurring') {
            $repeat = Input::get('repeat_type');
            $its = strtotime($idate);

            if ($repeat == 'week1') {
                $r = '+1 week';
                $nd = date('Y-m-d', strtotime('+1 week', $its));
            } elseif ($repeat == 'weeks2') {
                $r = '+2 weeks';
                $nd = date('Y-m-d', strtotime('+2 weeks', $its));
            } elseif ($repeat == 'month1') {
                $r = '+1 month';
                $nd = date('Y-m-d', strtotime('+1 month', $its));
            } elseif ($repeat == 'months2') {
                $r = '+2 months';
                $nd = date('Y-m-d', strtotime('+2 months', $its));
            } elseif ($repeat == 'months3') {
                $r = '+3 months';
                $nd = date('Y-m-d', strtotime('+3 months', $its));
            } elseif ($repeat == 'months6') {
                $r = '+6 months';
                $nd = date('Y-m-d', strtotime('+6 months', $its));
            } elseif ($repeat == 'year1') {
                $r = '+1 year';
                $nd = date('Y-m-d', strtotime('+1 year', $its));
            } elseif ($repeat == 'years2') {
                $r = '+2 years';
                $nd = date('Y-m-d', strtotime('+2 years', $its));
            } elseif ($repeat == 'years3') {
                $r = '+3 years';
                $nd = date('Y-m-d', strtotime('+3 years', $its));
            } else {
                return redirect('invoices/add')->with(array('message' => language_data('Date Parsing Error'), 'message_important' => true));
            }
            $ddate = $nd;
        } else {
            $r = '0';
        }

        if ($ddate == '') {
            return redirect('invoices/edit/' . $id)->with(array('message' => language_data('Invoice Due date is required'), 'message_important' => true));
        }

        $invoice = Invoices::find($id);

        if ($invoice) {
            $invoice->created = $idate;
            $invoice->duedate = $ddate;
            $invoice->subtotal = $sTotal;
            $invoice->total = $pTotal;
            $invoice->datepaid = $nd;
            $invoice->recurring = $r;
            $invoice->note = $notes;
            $invoice->save();
        } else {
            return redirect('invoices/edit/' . $id)->with([
                'message' => language_data('Invoice not found'),
                'message_true' => true
            ]);
        }
        InvoiceItems::where('inv_id', $id)->delete();
        $i = '0';
        foreach ($description as $item) {
            $ltotal = ($amount[$i]) * ($qty[$i]);
            $ttotal = ($ltotal * $tax[$i]) / 100;
            $dtotal = ($ltotal * $discount[$i]) / 100;
            $fTotal = $ltotal + $ttotal - $dtotal;
            $d = new InvoiceItems();
            $d->inv_id = $id;
            $d->cl_id = $cid;
            $d->item = $item;
            $d->qty = $qty[$i];
            $d->price = $amount[$i];
            $d->tax = $ttotal;
            $d->discount = $dtotal;
            $d->subtotal = $ltotal;
            $d->total = $fTotal;
            $d->save();
            $i++;
        }
        return redirect('invoices/edit/' . $id)->with([
            'message' => language_data('Invoice Updated Successfully')
        ]);
    }

    //======================================================================
    // markInvoicePaid Function Start Here
    //======================================================================
    public function markInvoicePaid($id)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $invoice = Invoices::find($id);
        if ($invoice) {
            $invoice->status = 'Paid';
            $invoice->datepaid = date('Y-m-d');
            $invoice->save();

            return redirect('invoices/view/' . $id)->with([
                'message' => language_data('Invoice Marked as Paid')
            ]);

        } else {
            return redirect('invoices/all')->with([
                'message' => language_data('Invoice not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // markInvoiceUnpaid Function Start Here
    //======================================================================
    public function markInvoiceUnpaid($id)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $invoice = Invoices::find($id);
        if ($invoice) {
            $invoice->status = 'Unpaid';
            $invoice->save();

            return redirect('invoices/view/' . $id)->with([
                'message' => language_data('Invoice Marked as Unpaid')
            ]);

        } else {
            return redirect('invoices/all')->with([
                'message' => language_data('Invoice not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // markInvoicePartiallyPaid Function Start Here
    //======================================================================
    public function markInvoicePartiallyPaid($id)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $invoice = Invoices::find($id);
        if ($invoice) {
            $invoice->status = 'Partially Paid';
            $invoice->save();

            return redirect('invoices/view/' . $id)->with([
                'message' => language_data('Invoice Marked as Partially Paid')
            ]);

        } else {
            return redirect('invoices/all')->with([
                'message' => language_data('Invoice not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // markInvoiceCancelled Function Start Here
    //======================================================================
    public function markInvoiceCancelled($id)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $invoice = Invoices::find($id);
        if ($invoice) {
            $invoice->status = 'Cancelled';
            $invoice->save();

            return redirect('invoices/view/' . $id)->with([
                'message' => language_data('Invoice Marked as Cancelled')
            ]);

        } else {
            return redirect('invoices/all')->with([
                'message' => language_data('Invoice not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // clientIView Function Start Here
    //======================================================================
    public function clientIView($id)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $inv = Invoices::find($id);
        if ($inv) {
            $client = Client::where('status', 'Active')->find($inv->cl_id);
            $inv_items = InvoiceItems::where('inv_id', $id)->get();
            $tax_sum = InvoiceItems::where('inv_id', $id)->sum('tax');
            $dis_sum = InvoiceItems::where('inv_id', $id)->sum('discount');
            return view('admin.invoice-client-view', compact('client', 'inv', 'inv_items', 'tax_sum', 'dis_sum'));
        } else {
            return redirect('invoices/all')->with([
                'message' => language_data('Invoice not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // printView Function Start Here
    //======================================================================
    public function printView($id)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $inv = Invoices::find($id);
        if ($inv) {
            $client = Client::where('status', 'Active')->find($inv->cl_id);
            $inv_items = InvoiceItems::where('inv_id', $id)->get();
            $tax_sum = InvoiceItems::where('inv_id', $id)->sum('tax');
            $dis_sum = InvoiceItems::where('inv_id', $id)->sum('discount');
            return view('admin.invoice-print-view', compact('client', 'inv', 'inv_items', 'tax_sum', 'dis_sum'));
        } else {
            return redirect('invoices/all')->with([
                'message' => language_data('Invoice not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // downloadPdf Function Start Here
    //======================================================================
    public function downloadPdf($id)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $inv = Invoices::find($id);
        $client = Client::where('status', 'Active')->find($inv->cl_id);
        $inv_items = InvoiceItems::where('inv_id', $id)->get();
        $tax_sum = InvoiceItems::where('inv_id', $id)->sum('tax');
        $dis_sum = InvoiceItems::where('inv_id', $id)->sum('discount');
        $data = view('admin.invoice-print-view', compact('client', 'inv', 'inv_items', 'tax_sum', 'dis_sum'));
        $html = $data->render();
        $pdf = \App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4')->setOption('margin-bottom', 0);
        return $pdf->download('invoice.pdf');
    }

    //======================================================================
    // sendInvoiceEmail Function Start Here
    //======================================================================
    public function sendInvoiceEmail(Request $request)
    {

        $self = 'manage-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $id = Input::get('cmd');

        $v = \Validator::make($request->all(), [
            'subject' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('invoices/view/' . $id)->withErrors($v->errors());
        }
        $inv = Invoices::find($id);
        $client = Client::where('status', 'Active')->find($inv->cl_id);
        $inv_items = InvoiceItems::where('inv_id', $id)->get();
        $tax_sum = InvoiceItems::where('inv_id', $id)->sum('tax');
        $dis_sum = InvoiceItems::where('inv_id', $id)->sum('discount');
        $data = view('admin.invoice-print-view', compact('client', 'inv', 'inv_items', 'tax_sum', 'dis_sum'));
        $html = $data->render();
        $file_path = public_path('assets/invoice_file/Invoice_' . time() . '.pdf');
        $pdf = \App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html)->setPaper('a4')->setOption('margin-bottom', 0)->save($file_path);


        $sysEmail = app_config('Email');
        $sysCompany = app_config('AppName');

        $template = $request->message;
        $subject = $request->subject;
        $client_name = $client->fname . ' ' . $client->lname;

        $default_gt = app_config('Gateway');

        if ($default_gt == 'default') {

            $mail = new \PHPMailer();

            try {
                $mail->setFrom($sysEmail, $sysCompany);
                $mail->addAddress($client->email, $client_name);     // Add a recipient
                $mail->addAttachment($file_path);
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $subject;
                $mail->Body = $template;

                if (!$mail->send()) {
                    return redirect('invoices/view/' . $id)->with([
                        'message' => 'Please Check your Email Settings',
                        'message_important' => true
                    ]);
                } else {
                    return redirect('invoices/view/' . $id)->with([
                        'message' => language_data('Invoice Send Successfully')
                    ]);
                }

            } catch (\phpmailerException $e) {
                return redirect('invoices/view/' . $id)->with([
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
                $mail->addAddress($client->email, $client_name);     // Add a recipient
                $mail->addAttachment($file_path);

                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = $subject;
                $mail->Body = $template;

                if (!$mail->send()) {
                    return redirect('invoices/view/' . $id)->with([
                        'message' => language_data('Please Check your Email Settings'),
                        'message_important' => true
                    ]);
                } else {
                    return redirect('invoices/view/' . $id)->with([
                        'message' => language_data('Invoice Send Successfully')
                    ]);
                }

            } catch (\phpmailerException $e) {
                return redirect('invoices/view/' . $id)->with([
                    'message' => $e->getMessage(),
                    'message_important' => true
                ]);
            }
        }
    }


    //======================================================================
    // deleteInvoice Function Start Here
    //======================================================================
    public function deleteInvoice($id)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('invoices/all')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $self = 'all-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $inv = Invoices::find($id);
        if ($inv) {
            InvoiceItems::where('inv_id', $id)->delete();
            $inv->delete();

            return redirect('invoices/all')->with([
                'message' => language_data('Invoice deleted successfully'),
            ]);

        } else {
            return redirect('invoices/all')->with([
                'message' => language_data('Invoice not found'),
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // stopRecurringInvoice Function Start Here
    //======================================================================
    public function stopRecurringInvoice($id)
    {

        $self = 'recurring-invoices';
        if (Auth::user()->username !== 'admin') {
            $get_perm = Permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $inv = Invoices::find($id);
        if ($inv) {
            $inv->recurring = '0';
            $inv->save();

            return redirect('invoices/all')->with([
                'message' => language_data('Stop Recurring Invoice Successfully'),
            ]);

        } else {
            return redirect('invoices/all')->with([
                'message' => language_data('Invoice not found'),
                'message_important' => true
            ]);
        }
    }


}
