<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('session_id');
            $table->unsignedInteger('course_id');
            $table->string('batch_number', 20);
            $table->decimal('development_fee_local', 12,2)->nullable();
            $table->decimal('development_fee_foreign', 12,2)->nullable();
            $table->decimal('tuition_fee_local', 12,2)->nullable();
            $table->decimal('tuition_fee_foreign', 12,2)->nullable();
            $table->tinyInteger('total_phases');
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
        Schema::dropIfExists('session_details');
    }
}
