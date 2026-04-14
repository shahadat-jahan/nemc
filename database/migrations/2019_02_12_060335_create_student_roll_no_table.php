<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentRollNoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_roll_no', function (Blueprint $table) {
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('phase_id');
            $table->unsignedInteger('batch_type_id');
            $table->string('roll_no', 3);
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
        Schema::dropIfExists('student_roll_no');
    }
}
