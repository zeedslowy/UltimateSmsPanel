<?php

namespace App\Http\Controllers;

use App\Classes\Paynow;
use App\Classes\Paypal;
use App\Classes\TwoCheckout;
use App\Client;
use App\InvoiceItems;
use App\Invoices;
use App\PaymentGateways;
use App\SMSBundles;
use App\SMSPlanFeature;
use App\SMSPricePlan;
use Cartalyst\Stripe\Exception\StripeException;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Slydepay\Exception\ProcessPaymentException;
use Slydepay\Order\Order;
use Slydepay\Order\OrderItem;
use Slydepay\Order\OrderItems;
use Slydepay\Slydepay;
use Unicodeveloper\Paystack\Paystack;

class PaymentController extends Controller
{


    //======================================================================
    // payInvoice Function Start Here
    //======================================================================
    public function payInvoice(Request $request)
    {
        $cmd = Input::get('cmd');
        if ($request->gateway == '') {
            return redirect('user/invoices/view/' . $cmd)->with([
                'message' => language_data('Payment gateway required'),
                'message_important' => true
            ]);
        }

        $gateway = Input::get('gateway');
        $gat_info = PaymentGateways::where('settings', $gateway)->first();
        $invoice_items = InvoiceItems::where('inv_id', $cmd)->get();
        $invoice = Invoices::find($cmd);

        if ($gateway == 'paypal') {

            require_once app_path('Classes/Paypal.php');

            $paypal = new Paypal();

            $paypal->param('business', $gat_info->value);
            $paypal->param('return', url('/user/invoice/success/' . $cmd));
            $paypal->param('cancel_return', url('/user/invoice/cancel/' . $cmd));

            $i = 1;
            foreach ($invoice_items as $item) {
                $paypal->param('item_name_' . $i, $item->item);
                $paypal->param('amount_' . $i, $item->price);
                $paypal->param('item_number_' . $i, $i);
                $paypal->param('quantity_' . $i, $item->qty);
            }
            $paypal->param('upload', 1);
            $paypal->param('cmd', '_cart');
            $paypal->param('txn_type', 'cart');
            $paypal->param('num_cart_items', 1);
            $paypal->param('payment_gross', $invoice->total);
            $paypal->param('currency_code', app_config('Currency'));
            $paypal->gw_submit();

        }

        if ($gateway == '2checkout') {

            require_once app_path('Classes/TwoCheckout.php');

            $checkout = new TwoCheckout();

            $checkout->param('sid', $gat_info->value);
            $checkout->param('return_url', url('/user/invoice/success/' . $cmd));

            $i = 1;
            foreach ($invoice_items as $item) {
                $checkout->param('li_' . $i . '_name', $item->item);
                $checkout->param('li_' . $i . '_price', $item->price);
                $checkout->param('li_' . $i . '_quantity', $item->qty);
            }
            $checkout->param('card_holder_name', $invoice->client_name);
            $checkout->param('country', Auth::guard('client')->user()->country);
            $checkout->param('email', Auth::guard('client')->user()->email);
            $checkout->param('currency_code', app_config('Currency'));
            $checkout->gw_submit();
        }

        if ($gateway == 'payu') {

            $signature = "$gat_info->extra_value~$gat_info->value~invoiceId$invoice->id~$invoice->total~" . app_config('Currency');
            $signature = md5($signature);

            $order = array(
                'merchantId' => $gat_info->value,
                'ApiKey' => $gat_info->extra_value,
                'referenceCode' => 'invoiceId' . $invoice->id,
                'description' => 'Invoice No#' . $invoice->id,
                'amount' => $invoice->total,
                'tax' => '0',
                'taxReturnBase' => '0',
                'currency' => app_config('Currency'),
                'buyerEmail' => Auth::guard('client')->user()->email,
                'test' => '0',
                'signature' => $signature,
                'confirmationUrl' => url('/user/invoice/success/' . $cmd),
                'responseUrl' => url('/user/invoice/cancel/' . $cmd),
            );
            ?>

            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Please wait while you're redirected</title>
                <style type="text/css">
                    #redirect {
                        background: #f1f1f1;
                        font-family: Helvetica, Arial, sans-serif
                    }

                    #redirect-container {
                        width: 410px;
                        margin: 130px auto 0;
                        background: #fff;
                        border: 1px solid #b5b5b5;
                        -moz-border-radius: 5px;
                        -webkit-border-radius: 5px;
                        border-radius: 5px;
                        text-align: center
                    }

                    #redirect-container h1 {
                        font-size: 22px;
                        color: #5f5f5f;
                        font-weight: normal;
                        margin: 22px 0 26px 0;
                        padding: 0
                    }

                    #redirect-container p {
                        font-size: 13px;
                        color: #454545;
                        margin: 0 0 12px 0;
                        padding: 0
                    }

                    #redirect-container img {
                        margin: 0 0 35px 0;
                        padding: 0
                    }

                    .ajaxLoader {
                        margin: 80px 153px
                    }
                </style>
                <script type="text/javascript">
                    function timedText() {
                        setTimeout('msg1()', 2000)
                        setTimeout('msg2()', 4000)
                        setTimeout('document.MetaRefreshForm.submit()', 4000)
                    }

                    function msg1() {
                        document.getElementById('redirect-message').firstChild.nodeValue = 'Preparing Data...'
                    }

                    function msg2() {
                        document.getElementById('redirect-message').firstChild.nodeValue = 'Redirecting...'
                    }
                </script>
            </head>
            <?php echo "<body onLoad=\"document.forms['gw'].submit();\">\n"; ?>
            <div id="redirect-container">
                <h1>Please wait while you&rsquo;re redirected</h1>
                <p class="redirect-message" id="redirect-message">Loading Data...</p>
                <script type="text/javascript">timedText()</script>
            </div>
            <form method="post" action="https://gateway.payulatam.com/ppp-web-gateway" name="gw">
                <?php
                foreach ($order as $name => $value) {
                    echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
                }

                ?>
            </form>
            </body>
            </html>
            <?php
        }

        if ($gateway == 'stripe') {

            $stripe_amount = $invoice->total * 100;
            $plan_name = 'Invoice No#' . $invoice->id;
            $post_url = 'user/invoices/pay-with-stripe';
            return view('client.stripe', compact('gat_info', 'stripe_amount', 'cmd', 'plan_name', 'post_url'));

        }

        if ($gateway == 'slydepay') {

            require_once(app_path('libraray/vendor/autoload.php'));

            $slydepay = new Slydepay($gat_info->value, $gat_info->extra_value);

            $total = number_format((float)$invoice->total, '2', '.', '');

            $orderItems = new OrderItems([
                new OrderItem($invoice->id, "Invoice NO# $invoice->id", $total, 1)
            ]);
            $shippingCost = 0;
            $tax = 0;
            $order_id = _raid(5);

            $order = Order::createWithId($orderItems, $order_id, $shippingCost, $tax, $invoice->id);

            try {
                $response = $slydepay->processPaymentOrder($order);
                return redirect($response->redirectUrl());
            } catch (ProcessPaymentException $e) {
                return redirect('user/invoices/view/' . $invoice->id)->with([
                    'message' => $e->getMessage(),
                    'message_important' => true
                ]);
            }
        }

        if ($gateway == 'paystack') {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'amount' => $invoice->total * 100,
                    'email' => Auth::guard('client')->user()->email,
                    'metadata' => [
                        'invoice_id' => $invoice->id,
                        'request_type' => 'invoice_payment',
                    ]
                ]),
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer " . getenv('PAYSTACK_SECRET_KEY'),
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if ($err) {
                return redirect('user/invoices/view/' . $invoice->id)->with([
                    'message' => $err,
                    'message_important' => true
                ]);
            }

            $tranx = json_decode($response);

            if ($tranx->status != 1) {
                return redirect('user/invoices/view/' . $invoice->id)->with([
                    'message' => $tranx->message,
                    'message_important' => true
                ]);
            }

            return redirect($tranx->data->authorization_url);

        }

        if ($gateway == 'pagopar') {
            require_once(app_path('libraray/pagopar/Pagopar.php'));

            try {
                $db = new \DBPagopar(env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
                $pedidoPagoPar = new \Pagopar($cmd, $db);
                $buyer = new \BuyerPagopar();
                $buyer->name = Auth::guard('client')->user()->fname . ' ' . Auth::guard('client')->user()->lname;
                $buyer->email = Auth::guard('client')->user()->email;
                $buyer->tel = Auth::guard('client')->user()->phone;
                $buyer->cityId = 1;
                $buyer->doc = _raid(5);
                $buyer->typeDoc = "CI";
                $buyer->addr = Auth::guard('client')->user()->address1;
                $buyer->addRef = Auth::guard('client')->user()->address2;
                $buyer->ruc = '';
                $buyer->socialReason = null;
                $buyer->public_key = $gat_info->value;

                $pedidoPagoPar->publicKey = $gat_info->value;

                $pedidoPagoPar->order->addPagoparBuyer($buyer);

                foreach ($invoice_items as $item) {
                    $item_info = $item->id;
                    $item_info = new \ItemPagopar();

                    $item_info->name = $item->item;
                    $item_info->qty = $item->qty;
                    $item_info->price = $item->price;
                    $item_info->cityId = 1;
                    $item_info->category = 909;
                    $item_info->url_img = null;
                    $item_info->weight = null;
                    $item_info->desc = $item->item;
                    $item_info->productId = $item->id;
                    $item_info->sellerPhone = null;
                    $item_info->sellerAddress = app_config('Country');
                    $item_info->sellerAddressRef = '';
                    $item_info->sellerAddressCoo = null;
                    $item_info->sellerPublicKey = $gat_info->value;
                    $pedidoPagoPar->order->addPagoparItem($item_info);
                }


                $pedidoPagoPar->order->privateKey = $gat_info->extra_value;
                $pedidoPagoPar->order->publicKey = $gat_info->value;
                $pedidoPagoPar->order->typeOrder = 'VENTA-COMERCIO';
                $pedidoPagoPar->order->desc = "Invoice Payment";
                $pedidoPagoPar->order->periodOfDaysForPayment = 1;
                $pedidoPagoPar->order->periodOfHoursForPayment = 0;
                $json_pedido = $pedidoPagoPar->getMethodsOfShipping();


                $url = 'https://api.pagopar.com/api/comercios/1.1/iniciar-transaccion';
                $ch = curl_init($url);


                $jsonDataEncoded = json_encode($json_pedido);

                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Accept:application/json"));

                $result = curl_exec($ch);
                curl_close($ch);

                if ($result === false) {
                    return redirect('user/invoices/view/' . $invoice->id)->with([
                        'message' => curl_error($ch),
                        'message_important' => true
                    ]);
                }


                $result = json_decode($result);
                if (!$result) {
                    $pedidoPagoPar->newPagoparTransaction();
                } else {
                    $json = '{"100":" aex "}';
                    $pedidoPagoPar->newPagoparTransaction($json);
                }

            } catch (\Exception $e) {
                return redirect('user/invoices/view/' . $invoice->id)->with([
                    'message' => $e->getMessage(),
                    'message_important' => true
                ]);
            }

        }

        if ($gateway == 'paynow') {
            require_once app_path('Classes/Paynow.php');

            $paynow = new Paynow();

            //set POST variables
            $values = array(
                'resulturl' => url('/user/invoice/paynow/' . $cmd),
                'returnurl' => url('/user/invoice/paynow/' . $cmd),
                'reference' => _raid(10),
                'amount' => $invoice->total,
                'id' => $gat_info->value,
                'status' => 'Invoice No#' . $invoice->id
            );

            $fields_string = $paynow->CreateMsg($values, $gat_info->extra_value);

            //open connection
            $ch = curl_init();
            $url = 'https://www.paynow.co.zw/interface/initiatetransaction';

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($ch);

            //close connection
            curl_close($ch);

            if ($result) {
                $msg = $paynow->ParseMsg($result);

                //first check status, take appropriate action
                if (is_array($msg) && array_key_exists('status', $msg) && $msg["status"] == 'Error') {
                    return redirect('/user/invoice/cancel/' . $cmd)->with([
                        'message' => $msg['error'],
                        'message_important' => true
                    ]);

                } else if (is_array($msg) && array_key_exists('status', $msg) && $msg["status"] == 'Ok') {

                    //second, check hash
                    $validateHash = $paynow->CreateHash($msg, $gat_info->extra_value);
                    if ($validateHash != $msg["hash"]) {
                        $error = "Paynow reply hashes do not match : " . $validateHash . " - " . $msg["hash"];
                        return redirect('/user/invoice/cancel/' . $cmd)->with([
                            'message' => $error,
                            'message_important' => true
                        ]);

                    } else {

                        if (is_array($msg) && array_key_exists('browserurl', $msg)) {
                            $theProcessUrl = $msg["browserurl"];

                            $orders_data_file = storage_path('PayNowTransaction.ini');
                            //1. Saving mine to a PHP.INI type of file, you should save it to a db etc
                            $orders_array = array();
                            if (file_exists($orders_data_file)) {
                                $orders_array = parse_ini_file($orders_data_file, true);
                            }

                            $orders_array['InvoiceNo_' . $cmd] = $msg;

                            $paynow->write_php_ini($orders_array, $orders_data_file, true);


                            return redirect($theProcessUrl);

                        } else {
                            return redirect('/user/invoice/cancel/' . $cmd)->with([
                                'message' => 'Invalid transaction URL, cannot continue',
                                'message_important' => true
                            ]);
                        }
                    }
                } else {
                    $error = "Invalid status in from Paynow, cannot continue.";
                    return redirect('/user/invoice/cancel/' . $cmd)->with([
                        'message' => $error,
                        'message_important' => true
                    ]);
                }

            } else {
                $error = curl_error($ch);
                return redirect('/user/invoice/cancel/' . $cmd)->with([
                    'message' => $error,
                    'message_important' => true
                ]);
            }
        }


        if ($gateway == 'manualpayment') {
            $details = $gat_info->value;

            return view('client.bank-details', compact('details'));
        }
    }

//======================================================================
// cancelledInvoice Function Start Here
//======================================================================
    public function cancelledInvoice($id = '')
    {
        return redirect('user/invoices/view/' . $id)->with([
            'message' => language_data('Cancelled the Payment')
        ]);
    }

//======================================================================
// successInvoice Function Start Here
//======================================================================
    public function successInvoice($id)
    {
        $invoice = Invoices::find($id);

        if ($invoice) {
            $invoice->status = 'Paid';
            $invoice->save();
            return redirect('user/invoices/view/' . $id)->with([
                'message' => language_data('Invoice paid successfully')
            ]);
        } else {
            return redirect('user/invoices/all')->with([
                'message' => language_data('Invoice paid successfully')
            ]);
        }
    }

//======================================================================
// payWithStripe Function Start Here
//======================================================================
    public function payWithStripe(Request $request)
    {

        $cmd = Input::get('cmd');
        $invoice = Invoices::find($cmd);
        $gat_info = PaymentGateways::where('settings', 'stripe')->first();
        $stripe = Stripe::make($gat_info->extra_value, '2016-07-06');
        $email = client_info($invoice->cl_id)->email;

        try {
            $customer = $stripe->customers()->create([
                'email' => $email,
                'source' => $request->stripeToken
            ]);

            $customer_id = $customer['id'];


            $stripe->charges()->create([
                'customer' => $customer_id,
                'currency' => app_config('Currency'),
                'amount' => $invoice->total,
                'receipt_email' => $email
            ]);
            $invoice->status = 'Paid';
            $invoice->save();

            return redirect('user/invoices/view/' . $cmd)->with([
                'message' => language_data('Invoice paid successfully')
            ]);

        } catch (StripeException $e) {
            return redirect('user/invoices/view/' . $cmd)->with([
                'message' => $e->getMessage(),
                'message_important' => true
            ]);
        }
    }

//======================================================================
// purchaseSMSPlanPost Function Start Here
//======================================================================
    public function purchaseSMSPlanPost(Request $request)
    {

        $cmd = Input::get('cmd');
        if ($request->gateway == '') {
            return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                'message' => language_data('Payment gateway required'),
                'message_important' => true
            ]);
        }

        $gateway = Input::get('gateway');
        $gat_info = PaymentGateways::where('settings', $gateway)->first();
        $sms_plan = SMSPricePlan::find($cmd);

        if ($gateway == 'paypal') {

            require_once app_path('Classes/Paypal.php');

            $paypal = new Paypal();

            $paypal->param('business', $gat_info->value);
            $paypal->param('return', url('/user/sms/purchase-plan/success/' . $cmd));
            $paypal->param('cancel_return', url('/user/sms/purchase-plan/cancel/' . $cmd));
            $paypal->param('item_name_1', $sms_plan->plan_name);
            $paypal->param('amount_1', $sms_plan->price);
            $paypal->param('item_number_1', $sms_plan->id);
            $paypal->param('quantity_1', 1);
            $paypal->param('upload', 1);
            $paypal->param('cmd', '_cart');
            $paypal->param('txn_type', 'cart');
            $paypal->param('num_cart_items', 1);
            $paypal->param('payment_gross', $sms_plan->price);
            $paypal->param('currency_code', app_config('Currency'));
            $paypal->gw_submit();

        }

        if ($gateway == '2checkout') {
            require_once app_path('Classes/TwoCheckout.php');

            $checkout = new TwoCheckout();

            $checkout->param('sid', $gat_info->value);
            $checkout->param('return_url', url('/user/sms/purchase-plan/success/' . $cmd));
            $checkout->param('li_0_name', $sms_plan->plan_name);
            $checkout->param('li_0_price', $sms_plan->price);
            $checkout->param('li_0_quantity', 1);
            $checkout->param('card_holder_name', Auth::guard('client')->user()->fname . ' ' . Auth::guard('client')->user()->lname);
            $checkout->param('country', Auth::guard('client')->user()->country);
            $checkout->param('email', Auth::guard('client')->user()->email);
            $checkout->param('currency_code', app_config('Currency'));
            $checkout->gw_submit();
        }

        if ($gateway == 'payu') {

            $signature = "$gat_info->extra_value~$gat_info->value~smsplan$sms_plan->id~$sms_plan->price~" . app_config('Currency');
            $signature = md5($signature);

            $order = array(
                'merchantId' => $gat_info->value,
                'ApiKey' => $gat_info->extra_value,
                'referenceCode' => 'smsplan' . $sms_plan->id,
                'description' => 'Purchase ' . $sms_plan->plan_name . ' Plan',
                'amount' => $sms_plan->price,
                'tax' => '0',
                'taxReturnBase' => '0',
                'currency' => app_config('Currency'),
                'buyerEmail' => Auth::guard('client')->user()->email,
                'test' => '0',
                'signature' => $signature,
                'confirmationUrl' => url('/user/sms/purchase-plan/success/' . $cmd),
                'responseUrl' => url('/user/sms/purchase-plan/cancel/' . $cmd),
            );
            ?>

            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Please wait while you're redirected</title>
                <style type="text/css">
                    #redirect {
                        background: #f1f1f1;
                        font-family: Helvetica, Arial, sans-serif
                    }

                    #redirect-container {
                        width: 410px;
                        margin: 130px auto 0;
                        background: #fff;
                        border: 1px solid #b5b5b5;
                        -moz-border-radius: 5px;
                        -webkit-border-radius: 5px;
                        border-radius: 5px;
                        text-align: center
                    }

                    #redirect-container h1 {
                        font-size: 22px;
                        color: #5f5f5f;
                        font-weight: normal;
                        margin: 22px 0 26px 0;
                        padding: 0
                    }

                    #redirect-container p {
                        font-size: 13px;
                        color: #454545;
                        margin: 0 0 12px 0;
                        padding: 0
                    }

                    #redirect-container img {
                        margin: 0 0 35px 0;
                        padding: 0
                    }

                    .ajaxLoader {
                        margin: 80px 153px
                    }
                </style>
                <script type="text/javascript">
                    function timedText() {
                        setTimeout('msg1()', 2000)
                        setTimeout('msg2()', 4000)
                        setTimeout('document.MetaRefreshForm.submit()', 4000)
                    }

                    function msg1() {
                        document.getElementById('redirect-message').firstChild.nodeValue = 'Preparing Data...'
                    }

                    function msg2() {
                        document.getElementById('redirect-message').firstChild.nodeValue = 'Redirecting...'
                    }
                </script>
            </head>
            <?php echo "<body onLoad=\"document.forms['gw'].submit();\">\n"; ?>
            <div id="redirect-container">
                <h1>Please wait while you&rsquo;re redirected</h1>
                <p class="redirect-message" id="redirect-message">Loading Data...</p>
                <script type="text/javascript">timedText()</script>
            </div>
            <form method="post" action="https://gateway.payulatam.com/ppp-web-gateway" name="gw">
                <?php
                foreach ($order as $name => $value) {
                    echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
                }
                ?>
            </form>
            </body>
            </html>
            <?php
        }

        if ($gateway == 'stripe') {
            $plan_name = $sms_plan->plan_name;
            $stripe_amount = $sms_plan->price * 100;
            $post_url = 'user/sms/purchase-with-stripe';

            return view('client.stripe', compact('gat_info', 'stripe_amount', 'cmd', 'plan_name', 'post_url'));

        }

        if ($gateway == 'slydepay') {

            require_once(app_path('libraray/vendor/autoload.php'));

            $slydepay = new Slydepay($gat_info->value, $gat_info->extra_value);
            $orderItems = new OrderItems([
                new OrderItem($sms_plan->id, "SMS Plan Name# $sms_plan->plan_name", $sms_plan->price, 1)
            ]);
            $shippingCost = 0;
            $tax = 0;
            $order_id = _raid(5);

            $order = Order::createWithId($orderItems, $order_id, $shippingCost, $tax, $sms_plan->id);

            try {
                $response = $slydepay->processPaymentOrder($order);
                return redirect($response->redirectUrl());
            } catch (ProcessPaymentException $e) {
                return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                    'message' => $e->getMessage(),
                    'message_important' => true
                ]);
            }
        }

        if ($gateway == 'paystack') {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'amount' => $sms_plan->price * 100,
                    'email' => Auth::guard('client')->user()->email,
                    'metadata' => [
                        'plan_id' => $cmd,
                        'request_type' => 'purchase_plan',
                    ]
                ]),
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer " . getenv('PAYSTACK_SECRET_KEY'),
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if ($err) {
                return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                    'message' => $err,
                    'message_important' => true
                ]);
            }

            $tranx = json_decode($response);

            if ($tranx->status != 1) {
                return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                    'message' => $tranx->message,
                    'message_important' => true
                ]);
            }

            return redirect($tranx->data->authorization_url);

        }

        if ($gateway == 'pagopar') {
            require_once(app_path('libraray/pagopar/Pagopar.php'));

            try {
                $db = new \DBPagopar(env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
                $pedidoPagoPar = new \Pagopar($cmd, $db);
                $buyer = new \BuyerPagopar();
                $buyer->name = Auth::guard('client')->user()->fname . ' ' . Auth::guard('client')->user()->lname;
                $buyer->email = Auth::guard('client')->user()->email;
                $buyer->tel = Auth::guard('client')->user()->phone;
                $buyer->cityId = 1;
                $buyer->doc = rand(5, 5);
                $buyer->typeDoc = "CI";
                $buyer->addr = Auth::guard('client')->user()->address1;
                $buyer->addRef = Auth::guard('client')->user()->address2;
                $buyer->ruc = null;
                $buyer->socialReason = null;
                $buyer->public_key = $gat_info->value;

                $pedidoPagoPar->order->addPagoparBuyer($buyer);

                $item_info = new \ItemPagopar();

                $item_info->name = $sms_plan->plan_name;
                $item_info->qty = 1;
                $item_info->price = $sms_plan->price;
                $item_info->cityId = 1;
                $item_info->category = $sms_plan->id;
                $item_info->url_img = null;
                $item_info->weight = null;
                $item_info->desc = $sms_plan->plan_name;
                $item_info->productId = $sms_plan->id;
                $item_info->sellerPhone = null;
                $item_info->sellerAddress = app_config('Address');
                $item_info->sellerAddressRef = '';
                $item_info->sellerAddressCoo = null;
                $item_info->sellerPublicKey = $gat_info->value;
                $pedidoPagoPar->order->addPagoparItem($item_info);


                $pedidoPagoPar->order->publicKey = $gat_info->value;
                $pedidoPagoPar->order->privateKey = $gat_info->extra_value;
                $pedidoPagoPar->order->typeOrder = 'VENTA-COMERCIO';
                $pedidoPagoPar->order->desc = "Purchase " . $sms_plan->plan_name;
                $pedidoPagoPar->order->periodOfDaysForPayment = 1;
                $pedidoPagoPar->order->periodOfHoursForPayment = 0;
                $json_pedido = $pedidoPagoPar->getMethodsOfShipping();

                if (!$json_pedido) {
                    $pedidoPagoPar->newPagoparTransaction();
                } else {
                    $json = '{"100":" aex "}';
                    $pedidoPagoPar->newPagoparTransaction($json);
                }

            } catch (\Exception $e) {
                return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                    'message' => $e->getMessage(),
                    'message_important' => true
                ]);
            }

        }

        if ($gateway == 'paynow') {
            require_once app_path('Classes/Paynow.php');

            $paynow = new Paynow();

            //set POST variables
            $values = array(
                'resulturl' => url('/user/sms/purchase-plan/paynow/' . $cmd),
                'returnurl' => url('/user/sms/purchase-plan/paynow/' . $cmd),
                'reference' => _raid(10),
                'amount' => $sms_plan->price,
                'id' => $gat_info->value,
                'status' => $sms_plan->plan_name
            );

            $fields_string = $paynow->CreateMsg($values, $gat_info->extra_value);

            //open connection
            $ch = curl_init();
            $url = 'https://www.paynow.co.zw/interface/initiatetransaction';

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($ch);

            //close connection
            curl_close($ch);

            if ($result) {
                $msg = $paynow->ParseMsg($result);

                //first check status, take appropriate action
                if (is_array($msg) && array_key_exists('status', $msg) && $msg["status"] == 'Error') {
                    return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                        'message' => $msg['error'],
                        'message_important' => true
                    ]);

                } else if (is_array($msg) && array_key_exists('status', $msg) && $msg["status"] == 'Ok') {

                    //second, check hash
                    $validateHash = $paynow->CreateHash($msg, $gat_info->extra_value);
                    if ($validateHash != $msg["hash"]) {
                        $error = "Paynow reply hashes do not match : " . $validateHash . " - " . $msg["hash"];
                        return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                            'message' => $error,
                            'message_important' => true
                        ]);

                    } else {

                        if (is_array($msg) && array_key_exists('browserurl', $msg)) {
                            $theProcessUrl = $msg["browserurl"];

                            $orders_data_file = storage_path('PayNowTransaction.ini');
                            //1. Saving mine to a PHP.INI type of file, you should save it to a db etc
                            $orders_array = array();
                            if (file_exists($orders_data_file)) {
                                $orders_array = parse_ini_file($orders_data_file, true);
                            }

                            $orders_array['PurchasePlanID_' . $cmd] = $msg;

                            $paynow->write_php_ini($orders_array, $orders_data_file, true);


                            return redirect($theProcessUrl);

                        } else {
                            return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                                'message' => 'Invalid transaction URL, cannot continue',
                                'message_important' => true
                            ]);
                        }
                    }
                } else {
                    $error = "Invalid status in from Paynow, cannot continue.";
                    return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                        'message' => $error,
                        'message_important' => true
                    ]);
                }

            } else {
                $error = curl_error($ch);
                return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                    'message' => $error,
                    'message_important' => true
                ]);
            }
        }


        if ($gateway == 'manualpayment') {
            $details = $gat_info->value;
            return view('client.bank-details', compact('details'));
        }
    }


//======================================================================
// cancelledPurchase Function Start Here
//======================================================================
    public function cancelledPurchase($id = '')
    {
        return redirect('user/sms/sms-plan-feature/' . $id)->with([
            'message' => language_data('Cancelled the Payment')
        ]);
    }

//======================================================================
// successPurchase Function Start Here
//======================================================================
    public function successPurchase($id)
    {
        if ($id) {

            $sms_plan = SMSPricePlan::find($id);

            $get_balance = SMSPlanFeature::where('pid', $id)->first();
            $sms_balance = (int)$get_balance->feature_value;

            $client = Client::find(Auth::guard('client')->user()->id);

            $total_balance = $client->sms_limit + $sms_balance;
            $client->sms_limit = $total_balance;
            $client->save();

            $inv = new Invoices();
            $inv->cl_id = $client->id;
            $inv->client_name = $client->fname . ' ' . $client->lname;
            $inv->created_by = 1;
            $inv->created = date('Y-m-d');
            $inv->duedate = date('Y-m-d');
            $inv->datepaid = date('Y-m-d');
            $inv->subtotal = $sms_plan->price;
            $inv->total = $sms_plan->price;
            $inv->status = 'Paid';
            $inv->pmethod = '';
            $inv->recurring = '0';
            $inv->bill_created = 'yes';
            $inv->note = '';
            $inv->save();
            $inv_id = $inv->id;

            $d = new InvoiceItems();
            $d->inv_id = $inv_id;
            $d->cl_id = $client->id;
            $d->item = $sms_plan->plan_name . ' Plan';
            $d->qty = '1';
            $d->price = $sms_plan->price;
            $d->tax = '0';
            $d->discount = '0';
            $d->subtotal = $sms_plan->price;
            $d->total = $sms_plan->price;
            $d->save();

            return redirect('user/invoices/all')->with([
                'message' => language_data('Purchase successfully.Wait for administrator response')
            ]);

        } else {
            return redirect('user/sms/purchase-sms-plan')->with([
                'message' => language_data('Purchase successfully.Wait for administrator response')
            ]);
        }
    }

//======================================================================
// purchaseWithStripe Function Start Here
//======================================================================
    public function purchaseWithStripe(Request $request)
    {
        $cmd = Input::get('cmd');
        $sms_plan = SMSPricePlan::find($cmd);

        $get_balance = SMSPlanFeature::where('pid', $cmd)->first();
        $sms_balance = $get_balance->feature_name;

        $gat_info = PaymentGateways::where('settings', 'stripe')->first();
        $stripe = Stripe::make($gat_info->extra_value, '2016-07-06');
        $email = Auth::guard('client')->user()->email;

        try {
            $customer = $stripe->customers()->create([
                'email' => $email,
                'source' => $request->stripeToken
            ]);

            $customer_id = $customer['id'];

            $stripe->charges()->create([
                'customer' => $customer_id,
                'currency' => app_config('Currency'),
                'amount' => $sms_plan->price,
                'receipt_email' => $email,
            ]);


            $client = Client::find(Auth::guard('client')->user()->id);

            $total_balance = $client->sms_limit + $sms_balance;
            $client->sms_limit = $total_balance;
            $client->save();

            $inv = new Invoices();
            $inv->cl_id = $client->id;
            $inv->client_name = $client->fname . ' ' . $client->lname;
            $inv->created_by = 1;
            $inv->created = date('Y-m-d');
            $inv->duedate = date('Y-m-d');
            $inv->datepaid = date('Y-m-d');
            $inv->subtotal = $sms_plan->price;
            $inv->total = $sms_plan->price;
            $inv->status = 'Paid';
            $inv->pmethod = '';
            $inv->recurring = '0';
            $inv->bill_created = 'yes';
            $inv->note = '';
            $inv->save();
            $inv_id = $inv->id;

            $d = new InvoiceItems();
            $d->inv_id = $inv_id;
            $d->cl_id = $client->id;
            $d->item = $sms_plan->plan_name . ' Plan';
            $d->qty = '1';
            $d->price = $sms_plan->price;
            $d->tax = '0';
            $d->discount = '0';
            $d->subtotal = $sms_plan->price;
            $d->total = $sms_plan->price;
            $d->save();

            return redirect('user/invoices/all')->with([
                'message' => language_data('Purchase successfully.Wait for administrator response')
            ]);

        } catch (StripeException $e) {
            return redirect('user/sms/sms-plan-feature/' . $cmd)->with([
                'message' => $e->getMessage(),
                'message_important' => true
            ]);
        }
    }

//======================================================================
// slydepayReceiveCallback Function Start Here
//======================================================================
    public function slydepayReceiveCallback()
    {
        return redirect('dashboard')->with([
            'message' => language_data('Purchase successfully.Wait for administrator response')
        ]);
    }


//======================================================================
// purchaseSMSPlanPost Function Start Here
//======================================================================
    public function postBuyUnit(Request $request)
    {

        if ($request->gateway == '') {
            return redirect('user/sms/buy-unit')->with([
                'message' => language_data('Payment gateway required'),
                'message_important' => true
            ]);
        }

        $number_unit = $request->input('number_unit');

        $gateway = Input::get('gateway');
        $gat_info = PaymentGateways::where('settings', $gateway)->first();

        if ($gateway == 'paypal') {

            require_once app_path('Classes/Paypal.php');

            $paypal = new Paypal();

            $paypal->param('business', $gat_info->value);
            $paypal->param('return', url('/user/sms/buy-unit/success/' . $number_unit));
            $paypal->param('cancel_return', url('/user/sms/buy-unit/cancel'));
            $paypal->param('item_name_1', 'Purchase unit');
            $paypal->param('amount_1', $request->total);
            $paypal->param('item_number_1', '1');
            $paypal->param('quantity_1', '1');
            $paypal->param('upload', 1);
            $paypal->param('cmd', '_cart');
            $paypal->param('txn_type', 'cart');
            $paypal->param('num_cart_items', 1);
            $paypal->param('payment_gross', $request->total);
            $paypal->param('currency_code', app_config('Currency'));
            $paypal->gw_submit();

        }

        if ($gateway == 'payu') {

            $signature = "$gat_info->extra_value~$gat_info->value~buyunit" . _raid(5) . "~$request->total~" . app_config('Currency');
            $signature = md5($signature);

            $order = array(
                'merchantId' => $gat_info->value,
                'ApiKey' => $gat_info->extra_value,
                'referenceCode' => 'buyunit' . _raid(5),
                'description' => 'Purchase SMS Unit',
                'amount' => $request->total,
                'tax' => '0',
                'taxReturnBase' => '0',
                'currency' => app_config('Currency'),
                'buyerEmail' => Auth::guard('client')->user()->email,
                'test' => '0',
                'signature' => $signature,
                'confirmationUrl' => url('/user/sms/buy-unit/success/' . $number_unit),
                'responseUrl' => url('/user/sms/buy-unit/success/' . $number_unit),
            );
            ?>

            <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
            <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title>Please wait while you're redirected</title>
                <style type="text/css">
                    #redirect {
                        background: #f1f1f1;
                        font-family: Helvetica, Arial, sans-serif
                    }

                    #redirect-container {
                        width: 410px;
                        margin: 130px auto 0;
                        background: #fff;
                        border: 1px solid #b5b5b5;
                        -moz-border-radius: 5px;
                        -webkit-border-radius: 5px;
                        border-radius: 5px;
                        text-align: center
                    }

                    #redirect-container h1 {
                        font-size: 22px;
                        color: #5f5f5f;
                        font-weight: normal;
                        margin: 22px 0 26px 0;
                        padding: 0
                    }

                    #redirect-container p {
                        font-size: 13px;
                        color: #454545;
                        margin: 0 0 12px 0;
                        padding: 0
                    }

                    #redirect-container img {
                        margin: 0 0 35px 0;
                        padding: 0
                    }

                    .ajaxLoader {
                        margin: 80px 153px
                    }
                </style>
                <script type="text/javascript">
                    function timedText() {
                        setTimeout('msg1()', 2000)
                        setTimeout('msg2()', 4000)
                        setTimeout('document.MetaRefreshForm.submit()', 4000)
                    }

                    function msg1() {
                        document.getElementById('redirect-message').firstChild.nodeValue = 'Preparing Data...'
                    }

                    function msg2() {
                        document.getElementById('redirect-message').firstChild.nodeValue = 'Redirecting...'
                    }
                </script>
            </head>
            <?php echo "<body onLoad=\"document.forms['gw'].submit();\">\n"; ?>
            <div id="redirect-container">
                <h1>Please wait while you&rsquo;re redirected</h1>
                <p class="redirect-message" id="redirect-message">Loading Data...</p>
                <script type="text/javascript">timedText()</script>
            </div>
            <form method="post" action="https://gateway.payulatam.com/ppp-web-gateway" name="gw">
                <?php
                foreach ($order as $name => $value) {
                    echo "<input type=\"hidden\" name=\"$name\" value=\"$value\"/>\n";
                }
                ?>
            </form>
            </body>
            </html>
            <?php
        }

        if ($gateway == 'stripe') {
            $cmd = $number_unit;
            $plan_name = 'Purchase SMS Unit';
            $stripe_amount = $request->total * 100;
            $post_url = 'user/sms/buy-unit-with-stripe';
            return view('client.stripe', compact('gat_info', 'stripe_amount', 'cmd', 'plan_name', 'post_url'));

        }

        if ($gateway == '2checkout') {
            require_once app_path('Classes/TwoCheckout.php');

            $checkout = new TwoCheckout();

            $checkout->param('sid', $gat_info->value);
            $checkout->param('return_url', url('/user/sms/buy-unit/success/' . $number_unit));
            $checkout->param('li_0_name', 'Purchase SMS Unit');
            $checkout->param('li_0_price', $request->total);
            $checkout->param('li_0_quantity', 1);
            $checkout->param('card_holder_name', Auth::guard('client')->user()->fname . ' ' . Auth::guard('client')->user()->lname);
            $checkout->param('country', Auth::guard('client')->user()->country);
            $checkout->param('email', Auth::guard('client')->user()->email);
            $checkout->param('currency_code', app_config('Currency'));
            $checkout->gw_submit();
        }

        if ($gateway == 'slydepay') {

            require_once(app_path('libraray/vendor/autoload.php'));

            $slydepay = new Slydepay($gat_info->value, $gat_info->extra_value);
            $total = number_format((float)$request->total, '2', '.', '');
            $orderItems = new OrderItems([
                new OrderItem(_raid(5), "Purchase SMS Unit", $total, 1)
            ]);
            $shippingCost = 0;
            $tax = 0;
            $order_id = _raid(5);

            $order = Order::createWithId($orderItems, $order_id, $shippingCost, $tax, $order_id);

            try {
                $response = $slydepay->processPaymentOrder($order);
                return redirect($response->redirectUrl());
            } catch (ProcessPaymentException $e) {
                return redirect('/user/sms/buy-unit/cancel')->with([
                    'message' => $e->getMessage(),
                    'message_important' => true
                ]);
            }
        }

        if ($gateway == 'manualpayment') {
            $details = $gat_info->value;
            return view('client.bank-details', compact('details'));
        }


        if ($gateway == 'paystack') {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'amount' => $request->total * 100,
                    'email' => Auth::guard('client')->user()->email,
                    'metadata' => [
                        'unit_number' => $request->number_unit,
                        'unit_price' => $request->unit_price,
                        'pay_amount' => $request->pay_amount,
                        'trans_fee' => $request->trans_fee,
                        'request_type' => 'buy_unit',
                    ]
                ]),
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer " . getenv('PAYSTACK_SECRET_KEY'),
                    "content-type: application/json",
                    "cache-control: no-cache"
                ],
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if ($err) {
                return redirect('user/sms/buy-unit')->with([
                    'message' => $err,
                    'message_important' => true
                ]);
            }

            $tranx = json_decode($response);

            if ($tranx->status != 1) {
                return redirect('user/sms/buy-unit')->with([
                    'message' => $tranx->message,
                    'message_important' => true
                ]);
            }

            return redirect($tranx->data->authorization_url);

        }

        if ($gateway == 'pagopar') {
            require_once(app_path('libraray/pagopar/Pagopar.php'));

            try {
                $db = new \DBPagopar(env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
                $pedidoPagoPar = new \Pagopar($cmd, $db);
                $buyer = new \BuyerPagopar();
                $buyer->name = Auth::guard('client')->user()->fname . ' ' . Auth::guard('client')->user()->lname;
                $buyer->email = Auth::guard('client')->user()->email;
                $buyer->tel = Auth::guard('client')->user()->phone;
                $buyer->cityId = 1;
                $buyer->doc = rand(5, 5);
                $buyer->typeDoc = "CI";
                $buyer->addr = Auth::guard('client')->user()->address1;
                $buyer->addRef = Auth::guard('client')->user()->address2;
                $buyer->ruc = null;
                $buyer->socialReason = null;
                $buyer->public_key = $gat_info->value;

                $pedidoPagoPar->order->addPagoparBuyer($buyer);

                $item_info = new \ItemPagopar();

                $item_info->name = 'Purchase SMS Unit';
                $item_info->qty = 1;
                $item_info->price = $request->total;
                $item_info->cityId = 1;
                $item_info->category = 1;
                $item_info->url_img = null;
                $item_info->weight = null;
                $item_info->desc = 'Purchase SMS Unit';
                $item_info->productId = 1;
                $item_info->sellerPhone = null;
                $item_info->sellerAddress = app_config('Address');
                $item_info->sellerAddressRef = '';
                $item_info->sellerAddressCoo = null;
                $item_info->sellerPublicKey = $gat_info->value;
                $pedidoPagoPar->order->addPagoparItem($item_info);

                $pedidoPagoPar->order->publicKey = $gat_info->value;
                $pedidoPagoPar->order->privateKey = $gat_info->extra_value;
                $pedidoPagoPar->order->typeOrder = 'VENTA-COMERCIO';
                $pedidoPagoPar->order->desc = "Purchase SMS Unit";
                $pedidoPagoPar->order->periodOfDaysForPayment = 1;
                $pedidoPagoPar->order->periodOfHoursForPayment = 0;
                $json_pedido = $pedidoPagoPar->getMethodsOfShipping();

                if (!$json_pedido) {
                    $pedidoPagoPar->newPagoparTransaction();
                } else {
                    $json = '{"100":" aex "}';
                    $pedidoPagoPar->newPagoparTransaction($json);
                }

            } catch (\Exception $e) {
                return redirect('user/sms/buy-unit')->with([
                    'message' => $e->getMessage(),
                    'message_important' => true
                ]);
            }

        }


        if ($gateway == 'paynow') {
            require_once app_path('Classes/Paynow.php');

            $paynow = new Paynow();

            $ref = _raid(10);
            $number_unit = $ref . $number_unit;

            //set POST variables
            $values = array(
                'resulturl' => url('/user/sms/buy-unit/paynow/' . $number_unit),
                'returnurl' => url('/user/sms/buy-unit/paynow/' . $number_unit),
                'reference' => $ref,
                'amount' => $request->total,
                'id' => $gat_info->value,
                'status' => 'Purchase sms unit'
            );

            $fields_string = $paynow->CreateMsg($values, $gat_info->extra_value);

            //open connection
            $ch = curl_init();
            $url = 'https://www.paynow.co.zw/interface/initiatetransaction';

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $result = curl_exec($ch);

            //close connection
            curl_close($ch);

            if ($result) {
                $msg = $paynow->ParseMsg($result);

                //first check status, take appropriate action
                if (is_array($msg) && array_key_exists('status', $msg) && $msg["status"] == 'Error') {
                    return redirect('user/sms/buy-unit')->with([
                        'message' => $msg['error'],
                        'message_important' => true
                    ]);

                } else if (is_array($msg) && array_key_exists('status', $msg) && $msg["status"] == 'Ok') {

                    //second, check hash
                    $validateHash = $paynow->CreateHash($msg, $gat_info->extra_value);
                    if ($validateHash != $msg["hash"]) {
                        $error = "Paynow reply hashes do not match : " . $validateHash . " - " . $msg["hash"];
                        return redirect('user/sms/buy-unit')->with([
                            'message' => $error,
                            'message_important' => true
                        ]);

                    } else {

                        if (is_array($msg) && array_key_exists('browserurl', $msg)) {
                            $theProcessUrl = $msg["browserurl"];

                            $orders_data_file = storage_path('PayNowTransaction.ini');
                            //1. Saving mine to a PHP.INI type of file, you should save it to a db etc
                            $orders_array = array();
                            if (file_exists($orders_data_file)) {
                                $orders_array = parse_ini_file($orders_data_file, true);
                            }

                            $orders_array['BuyUnitID_' . $number_unit] = $msg;

                            $paynow->write_php_ini($orders_array, $orders_data_file, true);


                            return redirect($theProcessUrl);

                        } else {
                            return redirect('user/sms/buy-unit')->with([
                                'message' => 'Invalid transaction URL, cannot continue',
                                'message_important' => true
                            ]);
                        }
                    }
                } else {
                    $error = "Invalid status in from Paynow, cannot continue.";
                    return redirect('user/sms/buy-unit')->with([
                        'message' => $error,
                        'message_important' => true
                    ]);
                }

            } else {
                $error = curl_error($ch);
                return redirect('user/sms/buy-unit')->with([
                    'message' => $error,
                    'message_important' => true
                ]);
            }
        }

    }


    //======================================================================
    // buyUnitSuccess Function Start Here
    //======================================================================
    public function buyUnitSuccess($id)
    {

        $data = SMSBundles::where('unit_from', '>=', $id)->first();

        if ($data) {
            $unit_price = $data->price;
            $amount_to_pay = $id * $unit_price;
            $transaction_fee = ($amount_to_pay * $data->trans_fee) / 100;
            $total = $amount_to_pay + $transaction_fee;

            $client = Client::find(Auth::guard('client')->user()->id);

            $total_balance = $client->sms_limit + $id;
            $client->sms_limit = $total_balance;
            $client->save();

            $inv = new Invoices();
            $inv->cl_id = $client->id;
            $inv->client_name = $client->fname . ' ' . $client->lname;
            $inv->created_by = 1;
            $inv->created = date('Y-m-d');
            $inv->duedate = date('Y-m-d');
            $inv->datepaid = date('Y-m-d');
            $inv->subtotal = $amount_to_pay;
            $inv->total = $total;
            $inv->status = 'Paid';
            $inv->pmethod = '';
            $inv->recurring = '0';
            $inv->bill_created = 'yes';
            $inv->note = '';
            $inv->save();
            $inv_id = $inv->id;

            $d = new InvoiceItems();
            $d->inv_id = $inv_id;
            $d->cl_id = $client->id;
            $d->item = 'Purchase SMS Unit';
            $d->qty = $id;
            $d->price = $unit_price;
            $d->tax = $transaction_fee;
            $d->discount = '0';
            $d->subtotal = $amount_to_pay;
            $d->total = $total;
            $d->save();

            return redirect('user/invoices/all')->with([
                'message' => language_data('Purchase successfully.Wait for administrator response')
            ]);

        } else {
            return redirect('user/sms/buy-unit')->with([
                'message' => 'Data not found',
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // buyUnitCancel Function Start Here
    //======================================================================
    public function buyUnitCancel()
    {
        return redirect('user/sms/buy-unit')->with([
            'message' => language_data('Cancelled the Payment')
        ]);
    }


    //======================================================================
    // buyUnitWithStripe Function Start Here
    //======================================================================
    public function buyUnitWithStripe(Request $request)
    {

        $cmd = Input::get('cmd');
        $data = SMSBundles::where('unit_from', '>=', $cmd)->first();

        if (!$data) {
            return redirect('user/sms/buy-unit')->with([
                'message' => 'Data not found',
                'message_important' => true
            ]);
        }

        $gat_info = PaymentGateways::where('settings', 'stripe')->first();
        $stripe = Stripe::make($gat_info->extra_value, '2016-07-06');
        $client = Client::find(Auth::guard('client')->user()->id);
        $email = $client->email;


        $total_balance = $client->sms_limit + $cmd;
        $client->sms_limit = $total_balance;
        $client->save();

        $unit_price = $data->price;
        $amount_to_pay = $cmd * $unit_price;
        $transaction_fee = ($amount_to_pay * $data->trans_fee) / 100;
        $total = $amount_to_pay + $transaction_fee;

        try {
            $customer = $stripe->customers()->create([
                'email' => $email,
                'source' => $request->stripeToken
            ]);

            $customer_id = $customer['id'];

            $stripe->charges()->create([
                'customer' => $customer_id,
                'currency' => app_config('Currency'),
                'amount' => $total,
                'receipt_email' => $email,
            ]);


            $inv = new Invoices();
            $inv->cl_id = $client->id;
            $inv->client_name = $client->fname . ' ' . $client->lname;
            $inv->created_by = 1;
            $inv->created = date('Y-m-d');
            $inv->duedate = date('Y-m-d');
            $inv->datepaid = date('Y-m-d');
            $inv->subtotal = $amount_to_pay;
            $inv->total = $total;
            $inv->status = 'Paid';
            $inv->pmethod = 'Stripe';
            $inv->recurring = '0';
            $inv->bill_created = 'yes';
            $inv->note = '';
            $inv->save();
            $inv_id = $inv->id;

            $d = new InvoiceItems();
            $d->inv_id = $inv_id;
            $d->cl_id = $client->id;
            $d->item = 'Purchase SMS Unit';
            $d->qty = $cmd;
            $d->price = $unit_price;
            $d->tax = $transaction_fee;
            $d->discount = '0';
            $d->subtotal = $amount_to_pay;
            $d->total = $total;
            $d->save();

            return redirect('user/invoices/all')->with([
                'message' => language_data('Purchase successfully.Wait for administrator response')
            ]);

        } catch (StripeException $e) {
            return redirect('user/sms/buy-unit')->with([
                'message' => $e->getMessage(),
                'message_important' => true
            ]);
        }
    }



//======================================================================
// payStackCallback Function Start Here
//======================================================================
    public function payStackCallback()
    {
        $curl = curl_init();
        $reference = isset($_GET['reference']) ? $_GET['reference'] : '';
        if (!$reference) {
            return redirect('dashboard')->with([
                'message' => 'No reference supplied',
                'message_important' => true
            ]);
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "authorization: Bearer " . getenv('PAYSTACK_SECRET_KEY'),
                "cache-control: no-cache"
            ],
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        if ($err) {
            return redirect('dashboard')->with([
                'message' => $err,
                'message_important' => true
            ]);
        }

        $tranx = json_decode($response);

        if (!$tranx->status) {
            // there was an error from the API
            return redirect('dashboard')->with([
                'message' => $tranx->message,
                'message_important' => true
            ]);
        }

        if ('success' == $tranx->data->status) {

            $request_type = $tranx->data->metadata->request_type;

            if ($request_type == 'invoice_payment') {
                $id = $tranx->data->metadata->invoice_id;
                $invoice = Invoices::find($id);

                if ($invoice) {
                    $invoice->status = 'Paid';
                    $invoice->save();
                    return redirect('user/invoices/view/' . $id)->with([
                        'message' => language_data('Invoice paid successfully')
                    ]);
                } else {
                    return redirect('user/invoices/all')->with([
                        'message' => language_data('Invoice paid successfully')
                    ]);
                }
            }


            if ($request_type == 'buy_unit') {

                $unit_number = $tranx->data->metadata->unit_number;

                $client = Client::find(Auth::guard('client')->user()->id);

                $total_balance = $client->sms_limit + $unit_number;
                $client->sms_limit = $total_balance;
                $client->save();

                $inv = new Invoices();
                $inv->cl_id = $client->id;
                $inv->client_name = $client->fname . ' ' . $client->lname;
                $inv->created_by = 1;
                $inv->created = date('Y-m-d');
                $inv->duedate = date('Y-m-d');
                $inv->datepaid = date('Y-m-d');
                $inv->subtotal = ($unit_number * $tranx->data->metadata->unit_price);
                $inv->total = ($tranx->data->amount / 100);
                $inv->status = 'Paid';
                $inv->pmethod = 'Paystack';
                $inv->recurring = '0';
                $inv->bill_created = 'yes';
                $inv->note = '';
                $inv->save();
                $inv_id = $inv->id;

                $d = new InvoiceItems();
                $d->inv_id = $inv_id;
                $d->cl_id = $client->id;
                $d->item = 'Purchase SMS Unit';
                $d->qty = $unit_number;
                $d->price = $tranx->data->metadata->unit_price;
                $d->tax = $tranx->data->metadata->trans_fee;
                $d->discount = '0';
                $d->subtotal = ($unit_number * $tranx->data->metadata->unit_price);
                $d->total = ($tranx->data->amount / 100);
                $d->save();

                return redirect('user/invoices/all')->with([
                    'message' => language_data('Purchase successfully.Wait for administrator response')
                ]);

            }

            if ($request_type == 'purchase_plan') {

                $plan_id = $tranx->data->metadata->plan_id;
                $sms_plan = SMSPricePlan::find($plan_id);

                $get_balance = SMSPlanFeature::where('pid', $plan_id)->first();
                $sms_balance = $get_balance->feature_name;

                $client = Client::find(Auth::guard('client')->user()->id);

                $total_balance = $client->sms_limit + $sms_balance;
                $client->sms_limit = $total_balance;
                $client->save();

                $inv = new Invoices();
                $inv->cl_id = $client->id;
                $inv->client_name = $client->fname . ' ' . $client->lname;
                $inv->created_by = 1;
                $inv->created = date('Y-m-d');
                $inv->duedate = date('Y-m-d');
                $inv->datepaid = date('Y-m-d');
                $inv->subtotal = $sms_plan->price;
                $inv->total = $sms_plan->price;
                $inv->status = 'Paid';
                $inv->pmethod = '';
                $inv->recurring = '0';
                $inv->bill_created = 'yes';
                $inv->note = '';
                $inv->save();
                $inv_id = $inv->id;

                $d = new InvoiceItems();
                $d->inv_id = $inv_id;
                $d->cl_id = $client->id;
                $d->item = $sms_plan->plan_name . ' Plan';
                $d->qty = '1';
                $d->price = $sms_plan->price;
                $d->tax = '0';
                $d->discount = '0';
                $d->subtotal = $sms_plan->price;
                $d->total = $sms_plan->price;
                $d->save();

                return redirect('user/invoices/all')->with([
                    'message' => language_data('Purchase successfully.Wait for administrator response')
                ]);

            }

        } else {
            return redirect('dashboard')->with([
                'message' => 'Unknown error',
                'message_important' => true
            ]);
        }
    }


    //======================================================================
    // PayNow Payment Gateway Integration
    //======================================================================

    //======================================================================
    // getPaymentGatewayInfo Function Start Here
    //======================================================================
    public function getPaymentGatewayInfo($gateway = '')
    {
        $gat_info = PaymentGateways::where('settings', $gateway)->first();
        if ($gat_info) {
            return $gat_info;
        } else {
            return false;
        }
    }


//======================================================================
// payNowInvoice Function Start Here
//======================================================================
    public function payNowInvoice($id)
    {

        $gat_info = $this->getPaymentGatewayInfo('paynow');

        if ($gat_info) {

            $orders_data_file = storage_path('PayNowTransaction.ini');

            //Lets get our locally saved settings for this order
            $orders_array = array();
            if (file_exists($orders_data_file)) {
                $orders_array = parse_ini_file($orders_data_file, true);
            }

            $order_data = $orders_array['InvoiceNo_' . $id];

            if (is_array($order_data) && array_key_exists('pollurl', $order_data)) {

                $ch = curl_init();

                //set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $order_data['pollurl']);
                curl_setopt($ch, CURLOPT_POST, 0);
                curl_setopt($ch, CURLOPT_POSTFIELDS, '');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                //execute post
                $result = curl_exec($ch);

                if ($result) {
                    require_once app_path('Classes/Paynow.php');
                    $paynow = new Paynow();

                    //close connection
                    $msg = $paynow->ParseMsg($result);

                    $validateHash = $paynow->CreateHash($msg, $gat_info->extra_value);

                    if ($validateHash != $msg["hash"]) {
                        $this->cancelledInvoice($id);
                    } else {
                        $orders_array['InvoiceNo_' . $id] = $msg;
                        $orders_array['InvoiceNo_' . $id]['returned_from_paynow'] = 'yes';

                        $paynow->write_php_ini($orders_array, $orders_data_file, true);

                        if ($msg['status'] == 'Paid') {
                            $invoice = Invoices::find($id);

                            if ($invoice) {
                                $invoice->status = 'Paid';
                                $invoice->save();
                                return redirect('user/invoices/view/' . $id)->with([
                                    'message' => language_data('Invoice paid successfully')
                                ]);
                            } else {
                                return redirect('user/invoices/all')->with([
                                    'message' => language_data('Invoice paid successfully')
                                ]);
                            }
                        } else {
                            return redirect('user/invoices/view/' . $id)->with([
                                'message' => 'Invoice ' . $msg['status']
                            ]);
                        }

                    }
                } else {
                    $this->cancelledInvoice($id);
                }

            } else {
                $this->cancelledInvoice($id);
            }
        } else {
            $this->cancelledInvoice($id);
        }
    }


//======================================================================
// payNowPurchasePlan Function Start Here
//======================================================================
    public function payNowPurchasePlan($id)
    {
        if ($id) {

            $gat_info = $this->getPaymentGatewayInfo('paynow');

            if ($gat_info) {

                $orders_data_file = storage_path('PayNowTransaction.ini');

                //Lets get our locally saved settings for this order
                $orders_array = array();
                if (file_exists($orders_data_file)) {
                    $orders_array = parse_ini_file($orders_data_file, true);
                }

                $order_data = $orders_array['PurchasePlanID_' . $id];

                if (is_array($order_data) && array_key_exists('pollurl', $order_data)) {

                    $ch = curl_init();

                    //set the url, number of POST vars, POST data
                    curl_setopt($ch, CURLOPT_URL, $order_data['pollurl']);
                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, '');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    //execute post
                    $result = curl_exec($ch);

                    if ($result) {
                        require_once app_path('Classes/Paynow.php');
                        $paynow = new Paynow();

                        //close connection
                        $msg = $paynow->ParseMsg($result);

                        $validateHash = $paynow->CreateHash($msg, $gat_info->extra_value);

                        if ($validateHash != $msg["hash"]) {
                            $this->cancelledInvoice($id);
                        } else {
                            $orders_array['PurchasePlanID_' . $id] = $msg;
                            $orders_array['PurchasePlanID_' . $id]['returned_from_paynow'] = 'yes';

                            $paynow->write_php_ini($orders_array, $orders_data_file, true);

                            if ($msg['status'] == 'Paid' || $msg['status'] == 'Awaiting Delivery' || $msg['status'] == 'Delivered') {

                                if ($msg['status'] == 'Awaiting Delivery' || $msg['status'] == 'Delivered') {
                                    $invoice_status = 'Unpaid';
                                }


                                $sms_plan = SMSPricePlan::find($id);

                                $get_balance = SMSPlanFeature::where('pid', $id)->first();
                                $sms_balance = $get_balance->feature_name;

                                $client = Client::find(Auth::guard('client')->user()->id);
                                if ($msg['status'] == 'Paid') {
                                    $invoice_status = 'Paid';

                                    $total_balance = $client->sms_limit + $sms_balance;
                                    $client->sms_limit = $total_balance;
                                    $client->save();
                                }


                                $inv = new Invoices();
                                $inv->cl_id = $client->id;
                                $inv->client_name = $client->fname . ' ' . $client->lname;
                                $inv->created_by = 1;
                                $inv->created = date('Y-m-d');
                                $inv->duedate = date('Y-m-d');
                                $inv->datepaid = date('Y-m-d');
                                $inv->subtotal = $sms_plan->price;
                                $inv->total = $sms_plan->price;
                                $inv->status = $invoice_status;
                                $inv->pmethod = '';
                                $inv->recurring = '0';
                                $inv->bill_created = 'yes';
                                $inv->note = '';
                                $inv->save();
                                $inv_id = $inv->id;

                                $d = new InvoiceItems();
                                $d->inv_id = $inv_id;
                                $d->cl_id = $client->id;
                                $d->item = $sms_plan->plan_name . ' Plan';
                                $d->qty = '1';
                                $d->price = $sms_plan->price;
                                $d->tax = '0';
                                $d->discount = '0';
                                $d->subtotal = $sms_plan->price;
                                $d->total = $sms_plan->price;
                                $d->save();

                                return redirect('user/invoices/all')->with([
                                    'message' => language_data('Purchase successfully.Wait for administrator response')
                                ]);

                            } else {
                                return redirect('user/sms/sms-plan-feature/' . $id)->with([
                                    'message' => 'Purchase sms plan ' . $msg['status']
                                ]);
                            }

                        }
                    } else {
                        $this->cancelledPurchase($id);
                    }

                } else {
                    $this->cancelledPurchase($id);
                }
            } else {
                $this->cancelledPurchase($id);
            }

        } else {
            return redirect('user/sms/purchase-sms-plan')->with([
                'message' => 'Invalid request',
                'message_important' => true
            ]);
        }
    }

    //======================================================================
    // buyUnitByPayNow Function Start Here
    //======================================================================
    public function buyUnitByPayNow($id)
    {

        $number_unit = substr($id, 10);
        $data = SMSBundles::where('unit_from', '>=', $number_unit)->first();

        if ($data) {

            $gat_info = $this->getPaymentGatewayInfo('paynow');

            if ($gat_info) {

                $orders_data_file = storage_path('PayNowTransaction.ini');

                //Lets get our locally saved settings for this order
                $orders_array = array();
                if (file_exists($orders_data_file)) {
                    $orders_array = parse_ini_file($orders_data_file, true);
                }

                $order_data = $orders_array['BuyUnitID_' . $id];

                if (is_array($order_data) && array_key_exists('pollurl', $order_data)) {

                    $ch = curl_init();

                    //set the url, number of POST vars, POST data
                    curl_setopt($ch, CURLOPT_URL, $order_data['pollurl']);
                    curl_setopt($ch, CURLOPT_POST, 0);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, '');
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    //execute post
                    $result = curl_exec($ch);

                    if ($result) {
                        require_once app_path('Classes/Paynow.php');
                        $paynow = new Paynow();

                        //close connection
                        $msg = $paynow->ParseMsg($result);

                        $validateHash = $paynow->CreateHash($msg, $gat_info->extra_value);

                        if ($validateHash != $msg["hash"]) {
                            $this->buyUnitCancel();
                        } else {
                            $orders_array['BuyUnitID_' . $id] = $msg;
                            $orders_array['BuyUnitID_' . $id]['returned_from_paynow'] = 'yes';

                            $paynow->write_php_ini($orders_array, $orders_data_file, true);

                            if ($msg['status'] == 'Paid' || $msg['status'] == 'Awaiting Delivery' || $msg['status'] == 'Delivered') {


                                $unit_price = $data->price;
                                $amount_to_pay = $number_unit * $unit_price;
                                $transaction_fee = ($amount_to_pay * $data->trans_fee) / 100;
                                $total = $amount_to_pay + $transaction_fee;

                                $client = Client::find(Auth::guard('client')->user()->id);

                                if ($msg['status'] == 'Awaiting Delivery' || $msg['status'] == 'Delivered') {
                                    $invoice_status = 'Unpaid';
                                }

                                if ($msg['status'] == 'Paid') {
                                    $invoice_status = 'Paid';

                                    $total_balance = $client->sms_limit + $number_unit;
                                    $client->sms_limit = $total_balance;
                                    $client->save();
                                }


                                $inv = new Invoices();
                                $inv->cl_id = $client->id;
                                $inv->client_name = $client->fname . ' ' . $client->lname;
                                $inv->created_by = 1;
                                $inv->created = date('Y-m-d');
                                $inv->duedate = date('Y-m-d');
                                $inv->datepaid = date('Y-m-d');
                                $inv->subtotal = $amount_to_pay;
                                $inv->total = $total;
                                $inv->status = $invoice_status;
                                $inv->pmethod = '';
                                $inv->recurring = '0';
                                $inv->bill_created = 'yes';
                                $inv->note = '';
                                $inv->save();
                                $inv_id = $inv->id;

                                $d = new InvoiceItems();
                                $d->inv_id = $inv_id;
                                $d->cl_id = $client->id;
                                $d->item = 'Purchase SMS Unit';
                                $d->qty = $number_unit;
                                $d->price = $unit_price;
                                $d->tax = $transaction_fee;
                                $d->discount = '0';
                                $d->subtotal = $amount_to_pay;
                                $d->total = $total;
                                $d->save();

                                return redirect('user/invoices/all')->with([
                                    'message' => language_data('Purchase successfully.Wait for administrator response')
                                ]);
                            } else {
                                return redirect('user/sms/buy-unit')->with([
                                    'message' => 'Purchase buy unit ' . $msg['status']
                                ]);
                            }

                        }
                    } else {
                        $this->buyUnitCancel();
                    }

                } else {
                    $this->buyUnitCancel();
                }
            } else {
                $this->buyUnitCancel();
            }
        } else {
            return redirect('user/sms/buy-unit')->with([
                'message' => 'Data not found',
                'message_important' => true
            ]);
        }
    }


}