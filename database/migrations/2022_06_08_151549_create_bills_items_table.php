<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills_items', function (Blueprint $table) {
            $table->id();
            $table->longText('description')->nullable();
            $table->float('item_price')->default(0); 
            $table->float('gst')->default(0)->nullable(); 
            $table->integer('quantity')->default(1); 
            $table->float('discount')->default(0);
            $table->float('total')->default(0);
            $table->string('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
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
        Schema::dropIfExists('bills_items');
    }
}
