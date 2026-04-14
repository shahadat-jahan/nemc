<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('exam_id');
            $table->unsignedInteger('subject_group_id')->nullable();
            $table->unsignedInteger('subject_id')->nullable();
            $table->unsignedInteger('card_id')->nullable();
            $table->unsignedInteger('card_item_id')->nullable();
            $table->unsignedInteger('exam_type_id');
            $table->date('exam_date')->nullable();
            $table->time('exam_time')->nullable();
            $table->tinyInteger('result_published');
            $table->timestamp('result_publish_date')->nullable();
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
        Schema::dropIfExists('exam_subjects');
    }
}
