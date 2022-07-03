<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->nullableMorphs('belong'); //person
            // $table->integer('current_office_id')->index()->unsigned()->nullable();
            $table->bigInteger('no_list_items')->unsigned()->default(20);
            $table->bigInteger('content_font_size')->unsigned()->default(13);
            $table->enum('help_text',['Yes', 'No'])->default('Yes');
            $table->enum('bold_tab_nav',['Yes', 'No'])->default('No');
            // Data table
            $table->enum('show_list_export_buttons',[1, 0])->default(1);
            $table->enum('show_list_paging',[1, 0])->default(1);
            $table->enum('list_length_change',[1, 0])->default(1);
            $table->enum('show_list_search',[1, 0])->default(1);
            $table->enum('show_list_ordering',[1, 0])->default(0);
            $table->enum('show_list_info',[1, 0])->default(1);
            $table->enum('show_list_auto_width',[1, 0])->default(0);
            $table->enum('show_list_page_length',[1, 0])->default(1);

            // Printing
            $table->enum('show_logo_header_on_print',[1, 0])->default(1);

            //Sidebar
            $table->enum('sidebar_mini',[1, 0])->default(0); // Toggle sidebar
            $table->enum('office_quick_links',[1, 0])->default(0); // Show/Hide Office Quick links

            // Session
            $table->bigInteger('session_lifetime')->default(120); // Default Session Lifetime in Mn
            $table->enum('session_expire_onclose',['0','1'])->default(1); // Default Session Lifetime in Mn
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
        Schema::dropIfExists('personal_settings');
    }
}
