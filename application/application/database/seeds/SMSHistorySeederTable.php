<?php

use Illuminate\Database\Seeder;

class SMSHistorySeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\SMSHistory::truncate();

        $factory = \Faker\Factory::create();
        $limit = 200;

        for ($i = 0; $i < $limit ; $i++){
            if ($i%2){
                \App\SMSHistory::create([
                    'userid' => 1,
                    'sender' => $factory->firstName('male'),
                    'receiver' => $factory->e164PhoneNumber,
                    'message' => $factory->text(120),
                    'amount' => '1',
                    'status' => 'Failed',
                    'api_key' => '',
                    'use_gateway' => '1',
                    'send_by' => 'receiver'
                ]);
            }else{

                \App\SMSHistory::create([
                    'userid' => 1,
                    'sender' => $factory->firstName('female'),
                    'receiver' => $factory->e164PhoneNumber,
                    'message' => $factory->text(120),
                    'amount' => '1',
                    'status' => 'Success',
                    'api_key' => '',
                    'use_gateway' => '1',
                    'send_by' => 'sender'
                ]);
            }
        }

    }
}
