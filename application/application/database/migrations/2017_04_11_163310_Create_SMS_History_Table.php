<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSMSHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_sms_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid');
            $table->string('sender',100)->nullable();
            $table->string('receiver',20);
            $table->text('message');
            $table->integer('amount');
            $table->string('use_gateway',50);
            $table->string('api_key',50)->nullable();
            $table->text('status');
            $table->enum('send_by',['receiver','sender','api']);
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
        Schema::dropIfExists('sys_sms_history');
    }
}
