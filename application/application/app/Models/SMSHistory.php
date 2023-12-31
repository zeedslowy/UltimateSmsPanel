<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSHistory extends Model
{
    protected $table='sys_sms_history';
    protected $fillable=['userid','sender','receiver','message','amount','status','api_key','use_gateway','send_by'];
}
