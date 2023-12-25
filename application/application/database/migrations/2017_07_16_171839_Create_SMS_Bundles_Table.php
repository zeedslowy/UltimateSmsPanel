<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSMSBundlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_sms_bundles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unit_from',20)->nullable();
            $table->string('unit_to',20)->nullable();
            $table->string('price',20)->nullable();
            $table->string('trans_fee',5)->nullable();
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
        Schema::dropIfExists('sys_sms_bundles');
    }
}
