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
        Schema::create('jackpot_market_models', function (Blueprint $table) {
            $table->id();
            $table->string("market")->unique();
            $table->unsignedBigInteger("market_prize");
            $table->unsignedInteger("market_id")->unique();
            $table->boolean("market_active")->default(true);
            $table->unsignedInteger("games_count");
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
        Schema::dropIfExists('jackpot_market_models');
    }
};
