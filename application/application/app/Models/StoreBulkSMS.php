<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreBulkSMS extends Model
{
    protected $table='sys_bulk_sms';
    protected $fillable=['userid','sender','msg_data','type','use_gateway','status'];
}
