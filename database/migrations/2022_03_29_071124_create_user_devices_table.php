<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->enum('status', ['Active','Banned'])->default('Active');
            $table->string('session_id')->nullable();
            $table->string('os_name')->nullable();
            $table->string('os_version')->nullable();
            $table->string('browser_name')->nullable();
            $table->string('browser_version')->nullable();
            $table->text('navigator_userAgent')->nullable();
            $table->text('navigator_appVersion')->nullable();
            $table->text('navigator_platform')->nullable();
            $table->text('navigator_vendor')->nullable();
            $table->string('ip')->nullable();
            $table->string('countryName')->nullable();
            $table->string('countryCode')->nullable();
            $table->string('regionCode')->nullable();
            $table->string('regionName')->nullable();
            $table->string('cityName')->nullable();
            $table->string('zipCode')->nullable();
            $table->string('isoCode')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('areaCode')->nullable();
            $table->string('metroCode')->nullable();
            $table->timestamp('logout_time')->nullable();
            $table->string('google_lat')->nullable();
            $table->string('google_long')->nullable();
            $table->string('google_street')->nullable();
            $table->string('google_region')->nullable();
            $table->string('google_district')->nullable();
            $table->string('google_city')->nullable();
            $table->string('google_country')->nullable();
            $table->string('location_request')->nullable();
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
        Schema::dropIfExists('user_devices');
    }
}
