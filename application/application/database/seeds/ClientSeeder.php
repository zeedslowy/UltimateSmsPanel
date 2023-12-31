<?php

use Illuminate\Database\Seeder;
use App\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::truncate();

        Client::create([
            'groupid'=>'1',
            'parent'=>'0',
            'fname'=>'Shamim',
            'lname'=>'Rahman',
            'company'=>'CoderPixel',
            'website'=>'https://kashem.me',
            'email'=>'coderpixel@gmail.com',
            'username'=>'shamim',
            'password'=>bcrypt('12345678'),
            'address1'=>'4th Floor, House #11, Block #B, ',
            'address2'=>'Rampura, Banasree Project.',
            'state'=>'Dhaka',
            'city'=>'Dhaka',
            'postcode'=>'1219',
            'country'=>'Bangladesh',
            'phone'=>'8801700000000',
            'image'=>'profile.jpg',
            'datecreated'=>date('Y-m-d'),
            'sms_gateway'=>'1'
        ]);

    }
}
