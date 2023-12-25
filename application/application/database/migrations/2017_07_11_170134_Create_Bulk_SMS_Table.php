<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulkSMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_bulk_sms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userid');
            $table->string('sender',100)->nullable();
            $table->longText('msg_data');
            $table->integer('use_gateway');
            $table->enum('type',['plain','unicode'])->default('plain');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('sys_bulk_sms');
    }
}
