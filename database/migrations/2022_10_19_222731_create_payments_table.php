<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('account_name');
            $table->decimal('amount',15,2);
            $table->string('reference');
            $table->string('status')->default(0);
            $table->string('uuid',100);
            $table->string('payment_gateway');
            $table->unsignedBigInteger('tour_operators_id');
            $table->unsignedBigInteger('tourist_bookings_id');
            $table->timestamps();
        });
        Schema::table('payments',function (Blueprint $table){
            $table->foreign('tour_operators_id')->references('id')->on('tour_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('tourist_bookings_id')->references('id')->on('tourist_bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
