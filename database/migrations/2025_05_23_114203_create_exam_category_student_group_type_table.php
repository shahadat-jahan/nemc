<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamCategoryStudentGroupTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_category_student_group_type', function (Blueprint $table) {
            $table->unsignedInteger('student_group_type_id')->index();
            $table->unsignedInteger('exam_category_id')->index();
            $table->primary(['student_group_type_id', 'exam_category_id'], 'group_exam_primary');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('student_group_type_id')
                ->references('id')->on('student_group_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('exam_category_id')
                ->references('id')->on('exam_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('exam_category_student_group_type', function (Blueprint $table) {
            $table->dropForeign(['student_group_type_id']);
            $table->dropForeign(['exam_category_id']);
        });

        Schema::dropIfExists('exam_category_group_type');
    }
}
