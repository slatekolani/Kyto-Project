<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourOperatorAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_operator_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_gateway');
            $table->string('account_name');
            $table->string('account_number');
            $table->string('status')->default(0);
            $table->string('uuid',100);
            $table->unsignedBigInteger('tour_operators_id');
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
        Schema::dropIfExists('tour_operator_accounts');
    }
}
