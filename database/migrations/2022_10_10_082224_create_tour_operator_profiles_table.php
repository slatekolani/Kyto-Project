<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourOperatorProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_operator_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('about_company');
            $table->string('company_core_values');
            $table->string('company_experience');
            $table->string('company_team_image');
            $table->string('uuid',100)->unique();
            $table->unsignedBigInteger('tour_operators_id');
            $table->timestamps();
        });
        Schema::table('tour_operator_profiles',function (Blueprint $table){
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
        Schema::dropIfExists('tour_operator_profiles');
    }
}
