<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSInbox extends Model
{
    protected $table='sys_sms_inbox';
    protected $fillable=['msg_id','amount','original_msg','encrypt_msg','status','ip','send_by'];
}
