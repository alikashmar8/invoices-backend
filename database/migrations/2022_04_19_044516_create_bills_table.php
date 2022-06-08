<?php

use App\Enums\DiscountType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->longText('description')->nullable();
            $table->float('total')->default(0);
            $table->float('gst')->default(0); 
            $table->float('discount')->default(0);
            $table->enum('discount_type', DiscountType::getValues())->default(DiscountType::AMOUNT);
            $table->string('reference_number')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->date('due_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('bills');
    }
}
