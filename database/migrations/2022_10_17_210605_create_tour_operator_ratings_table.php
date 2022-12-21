<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourOperatorRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_operator_ratings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('comment');
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('tour_operators_id');
            $table->string('uuid',100);
            $table->string('gender');
            $table->string('status')->default(0);
            $table->timestamps();
        });
        Schema::table('tour_operator_ratings',function (Blueprint $table){
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('tour_operator_ratings');
    }
}
