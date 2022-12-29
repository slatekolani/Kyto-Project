<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoloTripAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solo_trip_amount', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount_to_be_paid',15,2);
            $table->string('uuid',100);
            $table->unsignedBigInteger('solo_bookings_id');
            $table->timestamps();
        });
        Schema::table('solo_trip_amount',function (Blueprint $table){
            $table->foreign('solo_bookings_id')->references('id')->on('solo_bookings')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solo_trip_amounts');
    }
}
