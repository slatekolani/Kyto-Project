<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberNationalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_nationality', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nation_name');
            $table->string('nation_flag');
            $table->string('status')->default(1);
            $table->string('uuid',100);
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
        Schema::dropIfExists('member_nationalities');
    }
}
