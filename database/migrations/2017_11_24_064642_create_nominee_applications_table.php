<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNomineeApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominee_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('tax_certificate_sent_to');
            $table->string('id_verification_status');
            $table->string('is_us_person');
            $table->longText('details');
            $table->string('adobe_doc_key');
            $table->timestamp('doc_signed_date');
            $table->string('signed_url');
            $table->longText('financial_advisor_details');
            $table->longText('chargesfinancial_advisor_details');
            $table->timestamps();

            $table->foreign('user_id')
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
        Schema::dropIfExists('nominee_applications');
    }
}
