<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSendMediumColumnToSmsLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_email_log', function (Blueprint $table) {
            $table->string('send_medium')->after('subject')->nullable();
            $table->unsignedBigInteger('attendance_id')->after('id');
            $table->unsignedBigInteger('class_routine_id')->after('attendance_id');
            $table->unsignedInteger('created_by')->after('attendance_id');
            $table->unsignedInteger('update_by')->after('attendance_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_log', function (Blueprint $table) {
            //
        });
    }
}
