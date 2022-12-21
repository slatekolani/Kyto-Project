<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourOperatorBlogCostInclusivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_cost_inclusive', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cost_inclusive');
            $table->unsignedBigInteger('tour_operators_id');
            $table->unsignedBigInteger('tour_operators_blogs_id');
            $table->unsignedBigInteger('tour_operator_profiles_id');
            $table->string('uuid',100);
            $table->timestamps();
        });
        Schema::table('blog_cost_inclusive',function (Blueprint $table){
            $table->foreign('tour_operators_id')->references('id')->on('tour_operators')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('tour_operator_blog_cost_inclusives');
    }
}
