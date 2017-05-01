<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->longText('company_slogan')->nullable();
            $table->string('location');
            $table->string('company_contact_number');
            $table->string('company_email');
            $table->float('tax');
            $table->float('water_bill');
            $table->float('electric_bill');
            $table->float('rent');
            $table->float('labor');
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
        Schema::dropIfExists('company');
    }
}
