<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentFeeIdColumnToAdvanceAmountUseHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // This migration add new column "student_fee_detail_id" insted of "student_fee_id"
        Schema::table('advance_amount_use_histories', function (Blueprint $table) {
            $table->unsignedInteger('student_fee_detail_id')->after('student_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advance_amount_use_histories', function (Blueprint $table) {
            $table->dropColumn('student_fee_detail_id');
        });
    }
}
