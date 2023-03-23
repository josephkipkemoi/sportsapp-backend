<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jackpot_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id")->nullable();
            $table->unsignedInteger("jackpot_market_id");
            $table->unsignedInteger("game_id");
            $table->string("picked");
            $table->string("outcome")->nullable();
            $table->string('jackpot_bet_id');
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
        Schema::dropIfExists('jackpot_results');
    }
};
