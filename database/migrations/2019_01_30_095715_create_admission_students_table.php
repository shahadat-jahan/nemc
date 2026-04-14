<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_students', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admission_parent_id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('student_category_id');
            $table->unsignedInteger('session_id');
            $table->string('full_name_en');
            $table->string('full_name_bn')->nullable();
            $table->string('admission_roll_no', 10)->nullable();
            $table->date('form_fillup_date');
            $table->year('admission_year');
            $table->year('commenced_year');
            $table->float('test_score')->nullable();
            $table->float('merit_score')->nullable();
            $table->smallInteger('merit_position')->nullable();
            $table->string('gender', 10);
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->unsignedInteger('nationality');
            $table->string('mother_tongue')->nullable();
            $table->string('knowledge_english')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('passport_number', 40)->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->string('visa_duration', 20)->nullable();
            $table->string('embassy_contact_no', 20)->nullable();
            $table->string('permanent_address')->nullable();
            $table->boolean('same_as_permanent')->default(false);
            $table->string('present_address')->nullable();
            $table->string('photo')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('admission_students');
    }
}
