<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourOperatorBlogHoneyPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_honey_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('honey_point');
            $table->text('honey_point_description');
            $table->string('honey_point_image');
            $table->unsignedBigInteger('tour_operators_blogs_id');
            $table->unsignedBigInteger('tour_operators_id');
            $table->unsignedBigInteger('tour_operator_profiles_id');
            $table->string('uuid',100)->unique();
            $table->timestamps();
        });
        Schema::table('blog_honey_points',function(Blueprint $table){
            $table->foreign('tour_operators_blogs_id')->references('id')->on('tour_operators_blogs')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('tour_operators_id')->references('id')->on('tour_operators')->onUpdate('CASCADE')->onDelete('CASCADE');
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
        Schema::dropIfExists('tour_operator_blog_honey_points');
    }
}
