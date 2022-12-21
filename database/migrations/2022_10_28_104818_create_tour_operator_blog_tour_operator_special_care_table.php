<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourOperatorBlogTourOperatorSpecialCareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_operator_blog_tour_operator_special_care', function (Blueprint $table) {
            $table->integer('tour_operator_blog_id');
            $table->integer('tour_operator_special_care_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tour_operator_blog_tour_operator_special_care');
    }
}
