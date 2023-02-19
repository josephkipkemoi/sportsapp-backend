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
        Schema::create('jackpot_games', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('jackpot_market_id')
                ->references('market_id')
                ->on('jackpot_market_models')
                ->nullable();
            $table->string('home_team');
            $table->string('away_team');
            $table->unsignedFloat('home_odds');
            $table->unsignedFloat('draw_odds');
            $table->unsignedFloat('away_odds');
            $table->timestamp('kick_off_time');
            $table->boolean('game_started')->default(false);
            $table->boolean('game_ended')->default(false);
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
        Schema::dropIfExists('jackpot_games');
    }
};
