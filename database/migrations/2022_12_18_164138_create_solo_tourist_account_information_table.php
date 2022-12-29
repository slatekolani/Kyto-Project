<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoloTouristAccountInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solo_tourist_account_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_gateway');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('status')->default(0);
            $table->string('uuid',100);
            $table->unsignedBigInteger('solo_bookings_id');
            $table->timestamps();
        });
        Schema::table('solo_tourist_account_information',function (Blueprint $table){
            $table->foreign('solo_bookings_id')->references('id')->on('solo_bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solo_tourist_account_information');
    }
}
