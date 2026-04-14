<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassRoutineSessionBatchTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_routine_session_batch_types', function (Blueprint $table) {
            $table->unsignedInteger('class_routine_id');
            $table->unsignedInteger('session_id');
            $table->unsignedInteger('batch_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_routine_session_batch_types');
    }
}
