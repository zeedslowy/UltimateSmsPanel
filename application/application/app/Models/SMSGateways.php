<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSGateways extends Model
{
    protected $table='sys_sms_gateways';
    protected $fillable= ['name','api_link','username','password','api_id','type','two_way'];
}
