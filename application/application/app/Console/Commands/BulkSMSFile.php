<?php

namespace App\Console\Commands;

use App\CustomSMSGateways;
use App\Jobs\SendBulkSMS;
use App\SMSGateways;
use App\StoreBulkSMS;
use Illuminate\Console\Command;

class BulkSMSFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:sendbulk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Bulk SMS From File';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $bulk_sms = StoreBulkSMS::where('status','0')->get();
        foreach ($bulk_sms as $sms){
            $results = $sms->msg_data;
            $results = json_decode($results);
            $gateway = SMSGateways::find($sms->use_gateway);

            if ($gateway->custom == 'Yes') {
                $cg_info = CustomSMSGateways::where('gateway_id', $sms->use_gateway)->first();
            } else {
                $cg_info = '';
            }

            $sms->status='1';
            $sms->save();
            foreach ($results as $r) {
                dispatch(new SendBulkSMS($sms->userid,$r->phone_number, $gateway, $sms->sender, $r->message, $r->segments,$cg_info,'',$sms->type));
            }
            $sms->delete();
        }
    }
}
