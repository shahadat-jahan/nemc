<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('payment_type_id');
            $table->unsignedInteger('payment_method_id');
            $table->unsignedInteger('bank_id')->nullable();
            $table->string('bank_copy')->nullable();
            $table->decimal('amount', 12,2);
            $table->decimal('available_amount', 12,2);
            $table->date('payment_date')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('verify_payment')->default(0);
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
        Schema::dropIfExists('student_payments');
    }
}
