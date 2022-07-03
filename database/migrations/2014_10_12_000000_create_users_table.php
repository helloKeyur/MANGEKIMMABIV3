<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entered_by_id')->unsigned()->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->bigInteger('banned_by_id')->unsigned()->nullable();
            $table->bigInteger('comment_banned_by_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('verify_code')->nullable();
            $table->string('username');
            $table->string('email')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('img')->default('user.png')->nullable(); 
            $table->string('img_url')->nullable();
            $table->enum('gender', ['Female','Male'])->nullable();
            $table->enum('login', ['Allow','Restrict'])->default('Allow');
            $table->enum('status', ['Active','Banned'])->default('Active');
            $table->enum('comment_status', ['Active','Banned'])->default('Active');
            $table->enum('platform', ['Web','App'])->default('Web');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('description')->nullable();
            $table->text('banned_reason')->nullable();
            $table->string('notification_token')->nullable();
            $table->rememberToken();
            $table->enum('is_subscribed', ['true','false'])->default('false');
            $table->enum('is_verified', ['true','false'])->default('false');
            $table->timestamp('end_of_subscription_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


          
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
