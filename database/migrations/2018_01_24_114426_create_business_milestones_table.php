<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_milestones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id')->unsigned()->nullable();
            $table->integer('milestone_id')->unsigned()->nullable();
            $table->timestamps();

             $table->foreign( 'business_id' )
                  ->references( 'id' )
                  ->on( 'business_listings' )
                  ->onDelete( 'cascade' );            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_milestones');
    }
}
