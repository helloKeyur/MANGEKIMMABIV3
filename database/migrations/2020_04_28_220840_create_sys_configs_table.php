<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_configs', function (Blueprint $table) {
            $table->bigIncrements('id');
             // General Config
            $table->string('system_name')->default(""); //
            $table->string('system_title')->default("Mange Kimambi"); //
            $table->string('logo_words')->default("Mange Kimambi"); // Words appear after the HMMS Logo
            $table->string('system_description')->default("Mange Kimambi"); //
            $table->string('user_default_pass')->default("456123"); //


            // Management
            $table->string('staff_default_login')->default("Allow"); //
            $table->bigInteger('staff_leaves_days')->default(28); // Maxmum number of days for staff leave
            $table->bigInteger('main_stock_office_id')->index()->unsigned()->nullable(); // Main Stock Office

            //Advanced Config
            // $table->integer('max_execution_time')->default(500); // Default php max waiting time
            $table->bigInteger('max_execution_time')->default(43200); // Default php max waiting time
            $table->bigInteger('show_alert_time')->default(5000); // Default show alert time time
            $table->bigInteger('max_size_upload')->default(500); // Max file upload file size
            $table->string('cron_job_url')->nullable(); //

            // Financial
            $table->decimal('admit_fee',12,2)->default(0.0);
            $table->decimal('staff_incentive_rate',4,2)->default(0.0);
            $table->enum('cash_only', ['Yes', 'No'])->default('No'); //  Only cash payment accepted
            $table->enum('app_status', ['production', 'maintenance'])->default('production'); //  Allow patient to pay for sessions beforehand accepted

            $table->string('app_version')->nullable(); 
            $table->enum('registration_fee', ['Yes', 'No'])->default('No'); //  Show registration fee select list on admission.
            $table->enum('create_provide_prescription_creation', ['Yes', 'No'])->default('No'); //  create_provide_prescription_creation


            $table->string('client_short_name')->nullable();
            $table->string('client_full_name')->nullable();
            $table->string('region_country')->nullable();
            $table->string('address')->nullable();
            $table->string('mob_no')->nullable();
            $table->string('tel_no')->nullable();
            $table->string('client_email')->nullable();
            $table->string('logo')->default('logo.png')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('print_logo')->nullable(); //
            $table->string('domain_name')->nullable(); //
            // Not editable
            $table->timestamp('install_date');
            $table->string('version')->default('0.1');
            $table->string('client_code')->default('default');
            $table->string('reg_initial')->default('default');
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
        Schema::dropIfExists('sys_configs');
    }
}
