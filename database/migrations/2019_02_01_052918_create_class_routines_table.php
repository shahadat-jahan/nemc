<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassRoutinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_routines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('session_id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('batch_type_id');
            $table->unsignedInteger('phase_id');
            $table->unsignedInteger('term_id')->nullable();
            $table->unsignedInteger('subject_id');
            $table->unsignedInteger('teacher_id')->nullable();
            $table->unsignedInteger('class_type_id');
            $table->unsignedInteger('topic_id')->nullable();
//            $table->unsignedInteger('student_group_id')->nullable();
            $table->unsignedInteger('hall_id')->nullable();
            $table->date('class_date');
            $table->time('start_from');
            $table->time('end_at');
            $table->boolean('old_students')->default(0);
            $table->string('remarks')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('class_routines');
    }
}
