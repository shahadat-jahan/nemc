<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionStudentEducationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_education_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admission_student_id');
            $table->unsignedInteger('education_board_id');
            $table->tinyInteger('education_level');
            $table->string('institution');
            $table->year('pass_year');
            $table->float('gpa');
            $table->float('gpa_biology');
            $table->string('extra_activity')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('admission_education_histories');
    }
}
