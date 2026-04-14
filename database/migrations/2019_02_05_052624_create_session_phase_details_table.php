<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionPhaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_phase_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('session_detail_id');
            $table->unsignedInteger('phase_id');
            $table->tinyInteger('total_terms');
            $table->string('duration')->comment('in years')->nullable();
            $table->string('exam_title')->nullable();
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
        Schema::dropIfExists('session_phase_details');
    }
}
