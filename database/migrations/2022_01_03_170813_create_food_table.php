<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entered_by_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->text('img_url')->nullable();
            $table->date('date')->nullable();
            $table->integer('takes_time')->nullable();
            $table->integer('person')->nullable();
            $table->enum('category', ['Breakfast ','Lunch','Snack','Dinner','Other'])->nullable();
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
        Schema::dropIfExists('food');
    }
}
