<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentNoticeBoardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_notice_board', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('notice_board_id');
            $table->unsignedInteger('department_id');
            $table->timestamps();

            $table->foreign('notice_board_id')->references('id')->on('notice_boards')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_notice_board');
    }
}
