<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessListingDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_listing_datas', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('business_id')->unsigned();
            $table->string('data_key');
            $table->longText('data_value');
            $table->timestamps();

            $table->foreign('business_id')
                ->references('id')
                ->on('business_listings')
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
        Schema::dropIfExists('business_listing_datas');
    }
}
