<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('department_id');
            $table->unsignedInteger('designation_id');
            $table->unsignedInteger('course_id')->nullable();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->date('dob');
            $table->string('gender', 10);
            $table->string('phone', 20);
            $table->boolean('share_phone')->default(false);
            $table->string('email', 50);
            $table->boolean('share_email')->default(false);
            $table->string('address')->nullable();
            $table->string('photo')->nullable();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('teachers');
    }
}
