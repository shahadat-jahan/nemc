<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_payment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_payment_id');
            $table->unsignedInteger('student_fee_id');
            $table->unsignedInteger('student_fee_detail_id')->nullable();
            $table->decimal('amount', 12,2);
            $table->tinyInteger('status');
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
        Schema::dropIfExists('student_payment_details');
    }
}
