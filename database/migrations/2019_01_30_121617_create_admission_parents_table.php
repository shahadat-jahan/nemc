<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionParentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_parents', function (Blueprint $table) {
            $table->increments('id');
//            $table->enum('relation_type', ['Father', 'Mother', 'Guardian']);
            $table->string('father_name');
            $table->string('mother_name');
            $table->string('father_phone', 20)->nullable();
            $table->string('mother_phone', 20)->nullable();
            $table->string('father_email', 50)->nullable();
            $table->string('mother_email', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('occupation', 30)->nullable();
            $table->decimal('annual_income', 12,2)->nullable();
            $table->smallInteger('annual_income_grade')->nullable();
            $table->decimal('movable_property', 12,2)->nullable();
            $table->smallInteger('movable_property_grade')->nullable();
            $table->decimal('immovable_property', 12,2)->nullable();
            $table->smallInteger('immovable_property_grade')->nullable();
            $table->decimal('total_asset', 12,2)->nullable();
            $table->smallInteger('total_asset_grade')->nullable();
            $table->string('finance_during_study')->nullable();
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
        Schema::dropIfExists('admission_parents');
    }
}
