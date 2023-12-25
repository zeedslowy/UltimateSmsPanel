<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inv_id');
            $table->integer('cl_id');
            $table->text('item');
            $table->decimal('price',10,2)->default('0.00');
            $table->integer('qty')->default('0');
            $table->decimal('subtotal',10,2)->default('0.00');
            $table->decimal('tax',5,2)->default('0.00');
            $table->decimal('discount',5,2)->default('0.00');
            $table->decimal('total',10,2)->default('0.00');
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
        Schema::dropIfExists('sys_invoice_items');
    }
}
