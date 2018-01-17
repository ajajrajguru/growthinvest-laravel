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
            $table->longText('description')->nullable();
            $table->integer('parent_id')->default(0);
            $table->integer('type')->unsigned();
            $table->foreign('type')->references('id')->on('defaults')->onDelete('cascade');;
            $table->string('fca_ref_no'->nullable());
            $table->float('wm_commission')->nullable();
            $table->float('introducer_commission')->nullable();
            $table->string('invite_key');
            $table->longText('address1');
            $table->longText('address2')->nullable();
            $table->string('town')->nullable();
            $table->string('county')->nullable();
            $table->string('postcode');
            $table->string('country')->nullable();
            $table->integer('logoid')->nullable();
            $table->integer('backgroundid')->nullable();
            $table->char('frontend_display',3)->nullable();
            $table->char('backend_display',3)->nullable();
            $table->integer('blog')->nullable();
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
