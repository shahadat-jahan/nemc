<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('attachment_type_id');
            $table->unsignedInteger('admission_student_id');
            $table->string('file_path');
            $table->string('type', 30)->nullable()->comment('file extension');
            $table->string('remarks')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('admission_attachments');
    }
}
