<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entered_by_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->text('img_url')->nullable();
            $table->text('video_url')->nullable();
            $table->date('date')->nullable();
            $table->string('exercise_time')->nullable();
            $table->enum('circuit', ['Circuit 1','Circuit 2'])->nullable();
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('workouts');
    }
}
