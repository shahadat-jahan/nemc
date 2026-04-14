<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('campaign_type')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->string('receiver_type')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('email')->nullable();
            $table->text('message');
            $table->string('channel');
            $table->tinyInteger('status')->nullable();
            $table->string('delivery_status')->nullable();
            $table->json('response')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for faster reporting
            $table->index('receiver_id');
            $table->index('receiver_type');
            $table->index('status');
            $table->index('channel');
            $table->index('campaign_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaign_details');
    }
}
