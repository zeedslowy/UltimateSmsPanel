<?php

namespace App\Console\Commands;

use App\CustomSMSGateways;
use App\Jobs\SendBulkSMS;
use App\ScheduleSMS;
use App\SMSGateways;
use Illuminate\Console\Command;

class SendScheduleSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:schedule';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send schedule sms to user';

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
        $start_time=date('Y-m-d H:i').':00';
        $end_time=date('Y-m-d H:i').':59';

        $results = ScheduleSMS::whereBetween('submit_time',[$start_time,$end_time])->get();

        foreach ($results as $s){
            $gateway = SMSGateways::find($s->use_gateway);

            if ($gateway->custom == 'Yes') {
                $cg_info = CustomSMSGateways::where('gateway_id', $s->use_gateway)->first();
            } else {
                $cg_info = '';
            }

            dispatch(new SendBulkSMS($s->userid,$s->receiver, $gateway, $s->sender, $s->message, $s->amount,$cg_info,'',$s->type));
            $s->delete();
        }

    }
}
