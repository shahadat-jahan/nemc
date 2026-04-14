<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentFeeAdjustHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_fee_adjust_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_fee_id');
            $table->unsignedInteger('student_fee_detail_id');
            $table->unsignedInteger('payment_type_id');
            $table->decimal('total_amount', 12, 2)->nullable();
            $table->decimal('payable_amount', 12, 2)->nullable();
            $table->decimal('discount_amount', 12, 2)->nullable();
            $table->decimal('due_amount', 12, 2)->nullable();
            $table->tinyInteger('status')->default(0);  // 0 - Unpaid, 1 - Paid, 2 - Partially Paid
            $table->string('adjust_reason')->nullable();
            $table->unsignedInteger('adjust_by');
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
        Schema::dropIfExists('student_fee_adjust_histories');
    }
}
