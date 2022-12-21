<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_page', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tour_operators_blogs_id');
            $table->string('uuid',100);
            $table->timestamps();
        });
        Schema::table('home_page',function (Blueprint $table){
            $table->foreign('tour_operators_blogs_id')->references('id')->on('tour_operators_blogs')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_pages');
    }
}
