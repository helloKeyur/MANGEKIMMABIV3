<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entered_by_id')->unsigned()->nullable();
            $table->morphs('belong');
            $table->string('name')->nullable(); // added by user or post
            $table->text('original_file_name')->nullable();
            $table->string('file_size')->nullable(); // In kb
            $table->string('file_mime')->nullable(); // File type Video DOc
            $table->text('file_path');
            $table->enum('type', ['Image','Video','Others'])->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('media');
    }
}
