<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSerialNoToTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create new column after title column
        Schema::table('topics', function (Blueprint $table) {
            $table->integer('serial_number')->default(1)->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //drop created column
        Schema::table('topics', function($table) {
            $table->dropColumn('serial_number');
        });
    }
}
