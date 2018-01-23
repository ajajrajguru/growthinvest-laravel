<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_investments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('business_id');
            $table->integer('investor_id');
            $table->double('amount');
            $table->string('status',50);
            $table->longText('details');
            $table->longText('additional_details');
            $table->string('adobe_doc_key',50);
            $table->longText('data');            
            $table->integer('invested_fund_id');
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
        Schema::dropIfExists('business_investments');
    }
}
