<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTouristBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tourist_bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tourist_name');
            $table->string('phone_number');
            $table->string('email_address');
            $table->string('tourist_nation');
            $table->integer('number_of_tourists');
            $table->string('start_date');
            $table->string('end_date');
            $table->text('tourist_request');
            $table->string('uuid');
            $table->string('status')->default(0);
            $table->unsignedBigInteger('tour_operators_id');
            $table->unsignedBigInteger('tour_operators_blogs_id');
            $table->unsignedBigInteger('users_id');
            $table->timestamps();
        });
        Schema::table('tourist_bookings',function (Blueprint $table){
            $table->foreign('tour_operators_id')->references('id')->on('tour_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('tour_operators_blogs_id')->references('id')->on('tour_operators_blogs')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tourist_bookings');
    }
}
