<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('student_id');
            $table->string('title')->nullable();
            $table->decimal('total_amount', 12,2);
            $table->decimal('discount_amount', 12,2)->nullable();
            $table->decimal('payable_amount', 12,2);
            $table->decimal('paid_amount', 12,2)->nullable();
            $table->decimal('due_amount', 12,2)->nullable();
            $table->string('discount_application')->nullable();
            $table->string('remarks')->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('student_fees');
    }
}
