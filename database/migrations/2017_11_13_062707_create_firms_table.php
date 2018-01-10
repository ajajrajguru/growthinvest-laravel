<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::enableForeignKeyConstraints();

        Schema::create('firms', function (Blueprint $table)   {
            $table->increments('id');
            $table->string('gi_code');//->unique();
        /*    $table->string('firm_id')->unique();*/
            $table->string('name');
            $table->longText('description');
            $table->integer('parent_id')->default(0);
            $table->integer('type')->unsigned();
            $table->foreign('type')->references('id')->on('defaults')->onDelete('cascade');;
            $table->string('fca_ref_no');
            $table->float('wm_commission')->default(0);
            $table->float('introducer_commission')->default(0);
            $table->string('invite_key');
            $table->longText('address1');
            $table->longText('address2');
            $table->string('town');
            $table->string('county');
            $table->string('postcode');
            $table->string('country');
            $table->integer('logoid');
            $table->integer('backgroundid');
            $table->char('frontend_display',3);
            $table->char('backend_display',3);
            $table->integer('blog');
            $table->timestamps();
             
        });

        /*Schema::table('firms', function (Blueprint $table) {

                    $table->foreign('type')->references('id')->on('defaults');
                    //$table->foreign('address_id')->references('id')->on('addresses')->onUpdate('cascade');
                });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firms');
    }
}
