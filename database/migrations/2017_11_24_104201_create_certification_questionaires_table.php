<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificationQuestionairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certification_questionaires', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('certification_default_id')->unsigned();
            $table->longText('questions');
            $table->longText('options');
            $table->longText('answer')->nullable();
            $table->string('q_id');
            $table->integer('order')->nullable();
            $table->integer('deleted')->default();
            $table->timestamps();

            $table->foreign('certification_default_id')
                ->references('id')
                ->on('defaults')
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
        Schema::dropIfExists('certification_questionaires');
    }
}
