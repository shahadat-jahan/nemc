<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSerialNumberAndModifyTitleColumnToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //create new column after title column
        Schema::table('card_items', function (Blueprint $table) {
            $table->integer('serial_number')->after('title');
        });

        //change title column to text
        Schema::table('card_items', function (Blueprint $table) {
            $table->text('title')->change();
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
        Schema::table('card_items', function($table) {
            $table->dropColumn('serial_number');
        });

        // change title
        Schema::table('card_items', function (Blueprint $table) {
            $table->string('title')->change();
        });
    }
}
