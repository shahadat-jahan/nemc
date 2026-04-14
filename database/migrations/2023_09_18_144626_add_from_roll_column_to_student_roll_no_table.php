<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFromRollColumnToStudentRollNoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_roll_no', function (Blueprint $table) {
            $table->string('from_roll',3)->after('batch_type_id')->nullable();
            $table->renameColumn('roll_no', 'to_roll');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_roll_no', function (Blueprint $table) {
            $table->renameColumn('to_roll', 'roll_no');
        });
    }
}
