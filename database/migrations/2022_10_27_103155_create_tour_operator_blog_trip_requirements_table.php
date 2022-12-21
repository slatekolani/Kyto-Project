<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourOperatorBlogTripRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_trip_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trip_requirement');
            $table->text('reason_for_requirement');
            $table->unsignedBigInteger('tour_operators_id');
            $table->unsignedBigInteger('tour_operators_blogs_id');
            $table->unsignedBigInteger('tour_operator_profiles_id');
            $table->string('uuid');
            $table->timestamps();
        });
        Schema::table('blog_trip_requirements',function (Blueprint $table){
            $table->foreign('tour_operators_id')->references('id')->on('tour_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('tour_operators_blogs_id')->references('id')->on('tour_operators_blogs')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('tour_operator_profiles_id')->references('id')->on('tour_operator_profiles')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_operator_blog_trip_requirements');
    }
}
