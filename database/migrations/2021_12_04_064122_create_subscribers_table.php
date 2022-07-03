<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('name')->nullable();
            $table->string('msisdn')->nullable();
            $table->string('third_party_conversation_id')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->string('amount')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('status')->nullable();
            $table->text('message')->nullable();
            $table->string('device')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('app_version')->nullable();
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
        Schema::dropIfExists('subscribers');
    }
}
