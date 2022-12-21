<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoloBookingTripPalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solo_booking_trip_pals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tourist_name');
            $table->string('phone_number');
            $table->string('email_address');
            $table->decimal('trip_amount',15,2)->default(0000.00);
            $table->string('tourist_activation_status')->default(0);
            $table->string('payment_verification_status')->default(0);
            $table->unsignedBigInteger('solo_bookings_id');
            $table->string('uuid',100);
            $table->timestamps();
        });
        Schema::table('solo_booking_trip_pals',function (Blueprint $table){
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
        Schema::dropIfExists('solo_booking_trip_pals');
    }
}
