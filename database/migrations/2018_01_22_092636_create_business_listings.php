<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessListings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_listings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->longText('content');
            $table->longText('short_content');
            $table->string('status',50);
            $table->integer('parent');
            $table->string('type',50);
            $table->integer('round');
            $table->integer('proposal_logo_id');
            $table->integer('background_image_id');
            $table->double('target_amount');
            $table->double('pledged_amount');
            $table->double('funded_amount');
            $table->integer('watchlist_count');  
            $table->integer('owner_id')->unsigned(); 
            $table->string('gi_code');             
            $table->timestamps();

            $table->foreign('owner_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_listings');
    }
}