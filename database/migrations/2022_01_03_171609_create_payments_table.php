<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->string('transid')->nullable();
            $table->string('reference')->nullable();
            $table->string('channel')->nullable();
            $table->string('phone')->nullable();
            $table->string('amount')->nullable();
            $table->enum('payment_status',['COMPLETED','PENDING','FAIL'])->default('PENDING');
            $table->string('message')->nullable();
            $table->string('resultcode')->nullable();
            $table->string('result')->nullable();
            $table->string('gateway_buyer_uuid')->nullable();
            $table->string('qr')->nullable();
            $table->string('payment_token')->nullable();
            $table->string('payment_gateway_url')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
