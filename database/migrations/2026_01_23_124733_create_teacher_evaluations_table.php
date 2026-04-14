<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create teacher_evaluations table (main evaluation record)
        Schema::create('teacher_evaluations', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('student_id');
                $table->unsignedInteger('teacher_id');
                $table->unsignedInteger('session_id')->nullable();
                $table->unsignedInteger('course_id')->nullable();
                $table->unsignedInteger('phase_id')->nullable();
                $table->boolean('is_role_model')->default(false);
                $table->tinyInteger('status')->default(1);
                $table->unsignedInteger('created_by')->nullable();
                $table->unsignedInteger('updated_by')->nullable();
                $table->timestamps();
                $table->softDeletes();

                // Foreign keys
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
                $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
                $table->foreign('session_id')->references('id')->on('sessions')->onDelete('set null');
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');
                $table->foreign('phase_id')->references('id')->on('phases')->onDelete('set null');
                $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
                $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

                // Unique constraint: one evaluation per student-teacher-phase combination
                $table->unique(['student_id', 'teacher_id', 'phase_id'], 'unique_student_teacher_phase');
            });

        // Create pivot table for statement ratings
        if (!Schema::hasTable('teacher_evaluation_statements')) {
            Schema::create('teacher_evaluation_statements', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('teacher_evaluation_id');
                $table->tinyInteger('statement_id');
                $table->tinyInteger('rating');
                $table->timestamps();

                // Foreign key
                $table->foreign('teacher_evaluation_id')
                      ->references('id')
                      ->on('teacher_evaluations')
                      ->onDelete('cascade');

                // Index for performance
                $table->index('statement_id', 'te_stmt_statement_idx');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_evaluation_statements');
        Schema::dropIfExists('teacher_evaluations');
    }
}
