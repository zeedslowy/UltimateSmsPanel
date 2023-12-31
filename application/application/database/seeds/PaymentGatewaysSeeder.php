<?php

use Illuminate\Database\Seeder;
use App\PaymentGateways;

class PaymentGatewaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentGateways::truncate();

        $gateways=[
            [
                'name'=>'Paypal',
                'value'=>'apiemail@paypal.com',
                'settings'=>'paypal',
                'password'=>'api_password',
                'extra_value'=>'api_secret',
                'status'=>'Active',
            ],
            [
                'name'=>'Stripe',
                'value'=>'pk_test_ARblMczqDw61NusMMs7o1RVK',
                'settings'=>'stripe',
                'extra_value'=>'sk_test_BQokikJOvBiI2HlWgH4olfQ2',
                'status'=>'Active',
            ],
            [
                'name'=>'2CheckOut',
                'value'=>'Client_ID',
                'settings'=>'2checkout',
                'extra_value'=>'',
                'status'=>'Active',
            ],
            [
                'name'=>'Paystack',
                'value'=>'pk_test_25bdb768e32586e8d125b8eb8ddd71754296b310',
                'settings'=>'paystack',
                'extra_value'=>'sk_test_46823d69fa1990c3b1bfcb4b75ead975472164bf',
                'status'=>'Active',
            ],
            [
                'name'=>'PayU',
                'value'=>'300046',
                'settings'=>'payu',
                'extra_value'=>'c8d4b7ac61758704f38ed5564d8c0ae0',
                'status'=>'Active',
            ],
            [
                'name'=>'Slydepay',
                'value'=>'merchantEmail',
                'settings'=>'slydepay',
                'extra_value'=>'merchantSecretKey',
                'status'=>'Active',
            ],
            [
                'name'=>'Paynow',
                'value'=>'Integration_ID',
                'settings'=>'paynow',
                'extra_value'=>'Integration_Key',
                'status'=>'Active',
            ],
            [
                'name'=>'Pagopar',
                'value'=>'public_key',
                'settings'=>'pagopar',
                'extra_value'=>'private_key',
                'status'=>'Active',
            ],
            [
                'name'=>'Bank',
                'value'=>'Make a Payment to Our Bank Account &lt;br&gt;Bank Name: Bank Name &lt;br&gt;Account Name: Account Holder Name &lt;br&gt;Account Number: Account Number &lt;br&gt;',
                'settings'=>'manualpayment',
                'extra_value'=>'',
                'status'=>'Active',
            ]
        ];

        foreach ($gateways as $g){
            PaymentGateways::create($g);
        }

    }
}
