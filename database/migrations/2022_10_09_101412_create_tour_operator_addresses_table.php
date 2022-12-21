<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourOperatorAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_operator_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_operating_regions');
            $table->string('company_address');
            $table->string('company_contact');
            $table->unsignedBigInteger('tour_operators_id');
            $table->string('uuid')->unique();
            $table->timestamps();
        });
        Schema::table('tour_operator_addresses',function (Blueprint $table){
            $table->foreign('tour_operators_id')->references('id')->on('tour_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_operator_addresses');
    }
}
