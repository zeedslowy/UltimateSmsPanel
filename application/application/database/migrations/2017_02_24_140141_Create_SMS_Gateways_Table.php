<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSMSGatewaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_sms_gateways', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->longText('api_link')->nullable();
            $table->longText('username',50);
            $table->longText('password',100)->nullable();
            $table->longText('api_id',50)->nullable();
            $table->enum('schedule',['No','Yes'])->default('Yes');
            $table->enum('custom',['No','Yes'])->default('No');
            $table->enum('type',['http','smpp'])->default('http');
            $table->enum('status',['Active','Inactive'])->default('Active');
            $table->enum('two_way',['Yes','No'])->default('Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_sms_gateways');
    }
}
