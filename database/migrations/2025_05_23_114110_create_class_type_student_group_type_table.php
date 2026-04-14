<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTypeStudentGroupTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_type_student_group_type', function (Blueprint $table) {
            $table->unsignedInteger('student_group_type_id')->index();
            $table->unsignedInteger('class_type_id')->index();
            $table->primary(['student_group_type_id', 'class_type_id'], 'group_class_primary');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('student_group_type_id')
                ->references('id')->on('student_group_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('class_type_id')
                ->references('id')->on('class_types')
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
        Schema::table('class_type_student_group_type', function (Blueprint $table) {
            $table->dropForeign(['student_group_type_id']);
            $table->dropForeign(['class_type_id']);
        });

        Schema::dropIfExists('class_type_student_group_type');
    }
}
