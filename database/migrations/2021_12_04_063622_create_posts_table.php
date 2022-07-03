<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('author_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('featured_image')->nullable();
            $table->enum('status', ['Draft','Published', 'Ban']);
            $table->enum('is_video_segment', ['Yes','No'])->default('No');
            $table->longText('content')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('notification_id')->nullable();
            $table->bigInteger('deleted_by')->unsigned()->nullable();
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
        Schema::dropIfExists('posts');
    }
}
