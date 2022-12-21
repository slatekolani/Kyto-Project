<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourOperatorsBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_operators_blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('blog_topic');
            $table->decimal('visit_cost_local',15,2);
            $table->decimal('visit_cost_foreigner',15,2);
            $table->string('blog_topic_image');
            $table->integer('guarantee_percentage');
            $table->text('payment_condition');
            $table->string('payment_range');
            $table->integer('maximum_travellers');
            $table->integer('minimum_travellers');
            $table->string('trip_advisor_link');
            $table->text('trip_description');
            $table->unsignedBigInteger('tour_operators_id');
            $table->unsignedBigInteger('users_id');
            $table->string('uuid',100)->unique();
            $table->string('status')->default(0);
            $table->timestamps();
        });
        Schema::table('tour_operators_blogs',function(Blueprint $table){
            $table->foreign('tour_operators_id')->references('id')->on('tour_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('users_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_operators_blogs');
    }
}
