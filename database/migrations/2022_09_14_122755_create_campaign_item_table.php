<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_item', function (Blueprint $table) {
            $table->id();
           
            // Foreign Keys
            $table->foreignId('campaign_id')->references('id')->on('campaigns')->onDelete('cascade');
            $table->foreignId('item_id')->references('id')->on('items')->onDelete('cascade');

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
        Schema::dropIfExists('campaign_item');
    }
}
