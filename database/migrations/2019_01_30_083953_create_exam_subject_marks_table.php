<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamSubjectMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_subject_marks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exam_id');
            $table->unsignedInteger('subject_id');
//            $table->unsignedInteger('exam_type_id');
            $table->unsignedInteger('exam_sub_type_id')->nullable();
//            $table->unsignedInteger('student_group_id')->nullable();
//            $table->date('exam_date')->nullable();
//            $table->time('exam_time')->nullable();
            $table->float('total_marks');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('exam_subject_marks');
    }
}
