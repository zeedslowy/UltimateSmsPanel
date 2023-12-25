<?php

use Illuminate\Database\Seeder;
use App\SMSGateways;

class SMSGatewaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SMSGateways::truncate();

        $gateways = [
           [
                'name' => 'Twilio',
                'api_link' => '',
                'username' => 'username',
                'password' => 'auth_token',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'Yes'
            ],
            [
                'name' => 'Clickatell',
                'api_link' => 'http://api.clickatell.com',
                'username' => 'API_TOKEN',
                'password' => '',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'Yes'
            ],
            [
                'name' => 'Asterisk',
                'api_link' => 'http://127.0.0.1',
                'username' => 'username',
                'password' => 'secret',
                'api_id' => '5038',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Text Local',
                'api_link' => 'http://api.textlocal.in/send/',
                'username' => 'username',
                'password' => 'apihash',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'Yes'
            ],
            [
                'name' => 'Top10sms',
                'api_link' => 'http://trans.websmsapp.com/API/',
                'username' => 'username',
                'password' => 'api_key',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'msg91',
                'api_link' => 'http://api.msg91.com/api/sendhttp.php',
                'username' => 'username',
                'password' => 'auth_key',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Plivo',
                'api_link' => 'https://api.plivo.com/v1/Account/',
                'username' => 'auth_id',
                'password' => 'auth_token',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'Yes'
            ],
            [
                'name' => 'SMSGlobal',
                'api_link' => 'http://www.smsglobal.com/http-api.php',
                'username' => 'username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'Yes'
            ],
            [
                'name' => 'Bulk SMS',
                'api_link' => 'https://bulksms.vsms.net/eapi',
                'username' => 'username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'Yes'
            ],
            [
                'name' => 'Nexmo',
                'api_link' => 'https://rest.nexmo.com/sms/json',
                'username' => 'api_key',
                'password' => 'api_secret',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'Yes'
            ],
            [
                'name' => 'Route SMS',
                'api_link' => 'http://smsplus1.routesms.com:8080',
                'username' => 'username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SMSKaufen',
                'api_link' => 'http://www.smskaufen.com/sms/gateway/sms.php',
                'username' => 'API User Name',
                'password' => 'SMS API Key',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Kapow',
                'api_link' => 'http://www.kapow.co.uk/scripts/sendsms.php',
                'username' => 'username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Zang',
                'api_link' => '',
                'username' => 'account_sid',
                'password' => 'auth_token',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'InfoBip',
                'api_link' => 'https://api.infobip.com/sms/1/text/advanced',
                'username' => 'username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'Yes'
            ],
            [
                'name' => 'RANNH',
                'api_link' => 'http://rannh.com/sendsms.php',
                'username' => 'username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SMSIndiaHub',
                'api_link' => 'http://cloud.smsindiahub.in/vendorsms/pushsms.aspx',
                'username' => 'username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'ShreeWeb',
                'api_link' => 'http://sms.shreeweb.com/sendsms/sendsms.php',
                'username' => 'username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SmsGatewayMe',
                'api_link' => 'http://smsgateway.me/api/v3/messages/send',
                'username' => 'email',
                'password' => 'Password',
                'api_id' => 'device_id',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Elibom',
                'api_link' => 'https://www.elibom.com/messages',
                'username' => 'your_elibom_email',
                'password' => 'your_api_passwrod',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Hablame',
                'api_link' => 'https://api.hablame.co/sms/envio',
                'username' => 'client_id',
                'password' => 'api_secret',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Wavecell',
                'api_link' => 'https://api.wavecell.com/sms/v1/',
                'username' => 'sub_account_id',
                'password' => 'api_password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SIPTraffic',
                'api_link' => 'https://www.siptraffic.com',
                'username' => 'sub_account_id',
                'password' => 'api_password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SMSMKT',
                'api_link' => 'http://member.smsmkt.com/SMSLink/SendMsg/main.php',
                'username' => 'username',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'MLat',
                'api_link' => 'https://m-lat.net:8443/axis2/services/SMSServiceWS',
                'username' => 'user',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'NRSGateway',
                'api_link' => 'https://gateway.plusmms.net/send.php',
                'username' => 'tu_user',
                'password' => 'tu_login',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Orange',
                'api_link' => 'http://api.orange.com',
                'username' => 'client_id',
                'password' => 'client_secret',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'GlobexCam',
                'api_link' => 'http://panel.globexcamsms.com/api/mt/SendSMS',
                'username' => 'user',
                'password' => 'password',
                'api_id' => 'api_key',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Camoo',
                'api_link' => 'https://api.camoo.cm/v1/sms.json',
                'username' => 'api_key',
                'password' => 'api_secret',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Kannel',
                'api_link' => 'http://127.0.0.1:14002/cgi-bin/sendsms',
                'username' => 'username',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Semysms',
                'api_link' => 'https://semysms.net/api/3/sms.php',
                'username' => 'token',
                'password' => 'device',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Smsvitrini',
                'api_link' => 'http://api.smsvitrini.com/main.php',
                'username' => 'user_id',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Semaphore',
                'api_link' => 'http://api.semaphore.co/api/v4/messages',
                'username' => 'api_key',
                'password' => 'N/A',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Itexmo',
                'api_link' => 'https://www.itexmo.com/php_api/api.php',
                'username' => 'api_key',
                'password' => 'N/A',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Chikka',
                'api_link' => 'https://post.chikka.com/smsapi/request',
                'username' => 'client_id',
                'password' => 'Secret_key',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => '1s2u',
                'api_link' => 'https://1s2u.com/sms/sendsms/sendsms.asp',
                'username' => 'user_name',
                'password' => 'password',
                'api_id' => 'ipcl',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Kaudal',
                'api_link' => 'http://keudal.com/assmsserver/assmsserver',
                'username' => 'user_name',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'CMSMS',
                'api_link' => 'https://sgw01.cm.nl/gateway.ashx',
                'username' => 'product_token',
                'password' => 'N/A',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SendOut',
                'api_link' => 'https://www.sendoutapp.com/api/v2/envia',
                'username' => 'YOUR_NUMBER',
                'password' => 'API_TOKEN',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'ViralThrob',
                'api_link' => 'http://cmsprodbe.viralthrob.com/api/sms_outbounds/send_message',
                'username' => 'API_ACCESS_TOKEN',
                'password' => 'SAAS_ACCOUNT',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Masterksnetworks',
                'api_link' => 'http://api.masterksnetworks.com/sendsms/bulksms.php',
                'username' => 'Username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'MessageBird',
                'api_link' => 'https://rest.messagebird.com/messages',
                'username' => 'Access_Key',
                'password' => 'N/A',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'Yes'
            ],
            [
                'name' => 'FortDigital',
                'api_link' => 'https://mx.fortdigital.net/http/send-message',
                'username' => 'username',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SMSPRO',
                'api_link' => 'http://smspro.mtn.ci/bms/soap/messenger.asmx/HTTP_SendSms',
                'username' => 'userName',
                'password' => 'userPassword',
                'api_id' => 'customerID',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'CNIDCOM',
                'api_link' => 'http://www.cnid.com.py/api/api_cnid.php',
                'username' => 'api_key',
                'password' => 'api_secret',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Dialog',
                'api_link' => 'https://cpsolutions.dialog.lk/main.php/cbs/sms/send',
                'username' => 'API_Password',
                'password' => 'N/A',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'VoiceTrading',
                'api_link' => 'https://www.voicetrading.com/myaccount/sendsms.php',
                'username' => 'user_name',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'AmazonSNS',
                'username' => 'Access_key_ID',
                'password' => 'Secret_Access_Key',
                'api_id' => 'Region',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'NusaSMS',
                'api_link' => 'http://api.nusasms.com/api/v3/sendsms/plain',
                'username' => 'username',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SMS4Brands',
                'api_link' => 'http://sms4brands.com//api/sms-api.php',
                'username' => 'username',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'CheapGlobalSMS',
                'api_link' => 'http://cheapglobalsms.com/api_v1',
                'username' => 'sub_account',
                'password' => 'sub_account_pass',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'ExpertTexting',
                'api_link' => 'https://www.experttexting.com/ExptRestApi/sms/json/Message/Send',
                'username' => 'username',
                'password' => 'password',
                'api_id' => 'api_key',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'LightSMS',
                'api_link' => 'https://www.lightsms.com/external/get/send.php',
                'username' => 'Login',
                'password' => 'API_KEY',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Adicis',
                'api_link' => 'http://bs1.adicis.cd/gw0/tuma.php',
                'username' => 'username',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Smsconnexion',
                'api_link' => 'http://smsc.smsconnexion.com/api/gateway.aspx',
                'username' => 'username',
                'password' => 'passphrase',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'BrandedSMS',
                'api_link' => 'http://www.brandedsms.net//api/sms-api.php',
                'username' => 'username',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Ibrbd',
                'api_link' => 'http://wdgw.ibrbd.net:8080/bagaduli/apigiso/sender.php',
                'username' => 'username',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'TxtNation',
                'api_link' => 'http://client.txtnation.com/gateway.php',
                'username' => 'company',
                'password' => 'ekey',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'TeleSign',
                'api_link' => '',
                'username' => 'Customer ID',
                'password' => 'API_Key',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'JasminSMS',
                'api_link' => 'http://127.0.0.1',
                'username' => 'foo',
                'password' => 'bar',
                'api_id' => '1401',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Ezeee',
                'api_link' => 'http://my.ezeee.pk/sendsms_url.html',
                'username' => 'user_name',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ], [
                'name' => 'InfoBipSMPP',
                'api_link' => 'smpp3.infobip.com',
                'username' => 'system_id',
                'password' => 'password',
                'api_id' => '8888',
                'type' => 'smpp',
        'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SMSGlobalSMPP',
                'api_link' => 'smpp.smsglobal.com',
                'username' => 'system_id',
                'password' => 'password',
                'api_id' => '1775',
                'type' => 'smpp',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'ClickatellSMPP',
                'api_link' => 'smpp.clickatell.com',
                'username' => 'system_id',
                'password' => 'password',
                'api_id' => '2775',
                'type' => 'smpp',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'JasminSmsSMPP',
                'api_link' => 'host_name',
                'username' => 'system_id',
                'password' => 'password',
                'api_id' => 'port',
                'type' => 'smpp',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'WavecellSMPP',
                'api_link' => 'smpp.wavecell.com',
                'username' => 'system_id',
                'password' => 'password',
                'api_id' => '2775',
                'type' => 'smpp',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Moreify',
                'api_link' => 'https://mapi.moreify.com/api/v1/sendSms',
                'username' => 'project_id',
                'password' => 'your_token',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Digitalreachapi',
                'api_link' => 'https://digitalreachapi.dialog.lk/camp_req.php',
                'username' => 'user_name',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Tropo',
                'api_link' => 'https://api.tropo.com/1.0/sessions',
                'username' => 'api_token',
                'password' => '',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'CheapSMS',
                'api_link' => 'http://198.24.149.4/API/pushsms.aspx',
                'username' => 'loginID',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'CCSSMS',
                'api_link' => 'http://193.58.235.30:8001/api',
                'username' => 'Username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'MyCoolSMS',
                'api_link' => 'http://www.my-cool-sms.com/api-socket.php',
                'username' => 'Username',
                'password' => 'Password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SmsBump',
                'api_link' => 'https://api.smsbump.com/send',
                'username' => 'API_KEY',
                'password' => '',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'BSG',
                'api_link' => '',
                'username' => 'API_KEY',
                'password' => '',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'SmsBroadcast',
                'api_link' => 'https://api.smsbroadcast.co.uk/api-adv.php',
                'username' => 'username',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'BullSMS',
                'api_link' => 'http://portal.bullsms.com/vendorsms/pushsms.aspx',
                'username' => 'user',
                'password' => 'password',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ],
            [
                'name' => 'Skebby',
                'api_link' => 'https://api.skebby.it/API/v1.0/REST/sms',
                'username' => 'User_key',
                'password' => 'Access_Token',
                'api_id' => '',
                'type' => 'http',
                'status' => 'Inactive',
                'two_way' => 'No'
            ]
        ];

        foreach ($gateways as $g) {
            SMSGateways::create($g);
        }

    }
}
