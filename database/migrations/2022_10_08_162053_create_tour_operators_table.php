<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_operators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company_name');
            $table->string('phone_number');
            $table->string('email_address');
            $table->string('company_nation');
            $table->string('GPS_link');
            $table->string('whatsapp_direct_link');
            $table->string('company_website_url');
            $table->string('company_instagram_url');
            $table->string('logo');
            $table->string('status')->default(0);
            $table->string('booking_status')->default(0);
            $table->string('uuid',100)->unique();
            $table->unsignedBigInteger('users_id');
            $table->timestamps();
        });

        Schema::table('tour_operators',function(Blueprint $table){
            $table->foreign('users_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_operators');
    }
}
