<?php

use Illuminate\Database\Seeder;
use App\AppConfig;

class AppConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppConfig::truncate();

        $appconf = [
            [
                'setting' => 'AppName',
                'value' => 'Ultimate SMS'
            ],
            [
                'setting' => 'AppUrl',
                'value' => 'ultimatesms.coderpixel.com'
            ],
            [
                'setting' => 'purchase_key',
                'value' => ''
            ],
            [
                'setting' => 'valid_domain',
                'value' => 'yes'
            ],
            [
                'setting' => 'Email',
                'value' => 'akasham67@gmail.com'
            ],
            [
                'setting' => 'Address',
                'value' => 'House#11, Block#B, <br>Rampura<br>Banasree Project<br>Dhaka<br>1219<br>Bangladesh'
            ],
            [
                'setting' => 'SoftwareVersion',
                'value' => '2.2'
            ],
            [
                'setting' => 'AppTitle',
                'value' => 'Ultimate SMS - Bulk SMS Sending Application'
            ],
            [
                'setting' => 'FooterTxt',
                'value' => 'Copyright &copy; Codeglen - 2018'
            ],
            [
                'setting' => 'AppLogo',
                'value' => 'assets/img/logo.png'
            ],
            [
                'setting' => 'AppFav',
                'value' => 'assets/img/favicon.ico'
            ],
            [
                'setting' => 'Country',
                'value' => 'Bangladesh'
            ],
            [
                'setting' => 'Timezone',
                'value' => 'Asia/Dhaka'
            ],
            [
                'setting' => 'Currency',
                'value' => 'USD'
            ],
            [
                'setting' => 'CurrencyCode',
                'value' => '$'
            ], [
                'setting' => 'Gateway',
                'value' => 'default'
            ],
            [
                'setting' => 'SMTPHostName',
                'value' => 'smtp.gmail.com'
            ],
            [
                'setting' => 'SMTPUserName',
                'value' => 'user@example.com'
            ],
            [
                'setting' => 'SMTPPassword',
                'value' => 'testpassword'
            ],
            [
                'setting' => 'SMTPPort',
                'value' => '587'
            ],
            [
                'setting' => 'SMTPSecure',
                'value' => 'tls'
            ],
            [
                'setting' => 'AppStage',
                'value' => 'Live'
            ],
            [
                'setting' => 'DateFormat',
                'value' => 'jS M y'
            ],
            [
                'setting' => 'Language',
                'value' => '1'
            ],
            [
                'setting' => 'sms_api_permission',
                'value' => '1'
            ],
            [
                'setting' => 'sms_api_gateway',
                'value' => '1'
            ],
            [
                'setting' => 'api_url',
                'value' => 'https://ultimatesms.codeglen.com/demo'
            ],
            [
                'setting' => 'api_key',
                'value' => base64_encode('admin:admin.password')
            ],
            [
                'setting' => 'client_registration',
                'value' => '1'
            ],
            [
                'setting' => 'registration_verification',
                'value' => '0'
            ],
            [
                'setting' => 'captcha_in_admin',
                'value' => '0'
            ],
            [
                'setting' => 'captcha_in_client',
                'value' => '0'
            ],
            [
                'setting' => 'captcha_in_client_registration',
                'value' => '0'
            ],[
                'setting' => 'captcha_site_key',
                'value' => '6LcVTCEUAAAAAF2VucYNRFbnfD12MO41LpcS71o9'
            ],[
                'setting' => 'captcha_secret_key',
                'value' => '6LcVTCEUAAAAAGBbxACgcO6sBFPNIrMOkXJGh-Yu'
            ],[
                'setting' => 'purchase_code_error_count',
                'value' => '0'
            ],[
                'setting' => 'sender_id_verification',
                'value' => '1'
            ],[
                'setting' => 'license_type',
                'value' => ''
            ]

        ];

        foreach ($appconf as $ap) {
            AppConfig::create($ap);
        }

    }
}
