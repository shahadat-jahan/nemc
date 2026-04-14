<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhaseIdDepartmentIdColumnToNoticeBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notice_boards', function (Blueprint $table) {
            $table->unsignedInteger('course_id')->after('session_id')->nullable();
            $table->unsignedInteger('phase_id')->after('batch_type_id')->nullable();
            $table->unsignedInteger('department_id')->after('phase_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('phase_id')->references('id')->on('phases');
            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notice_boards', function (Blueprint $table) {
            //
        });
    }
}
