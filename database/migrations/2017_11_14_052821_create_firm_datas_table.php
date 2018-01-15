<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firm_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('firm_id')->unsigned();
            $table->string('data_key');
            $table->longText('data_value');
            $table->timestamps();

            $table->foreign('firm_id')
                ->references('id')
                ->on('firms')
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
        Schema::dropIfExists('firm_datas');
    }
}
