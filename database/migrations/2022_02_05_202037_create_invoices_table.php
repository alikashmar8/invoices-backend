<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->longText('title')->default('Invoice');
            $table->double('total')->default(0);
            $table->double('extra_amount')->default(0)->nullable();
            $table->double('discount')->default(0)->nullable();
            $table->integer('discount_type')->default(1);
            //$table->unsignedBigInteger('discount_type')->default(1);
            //$table->foreign('discount_type')->references('id')->on('discount_type')->onDelete('cascade');
            $table->longText('reference_number')->nullable()->unique();
            $table->boolean('is_paid')->default(true);
            $table->date('due_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
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
        Schema::dropIfExists('invoices');
    }
}
