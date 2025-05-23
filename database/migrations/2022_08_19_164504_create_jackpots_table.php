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
        Schema::create('jackpots', function (Blueprint $table) {
            $table->id();
            $table->string('jp_time');
            $table->string('jp_home');
            $table->string('jp_away');
            $table->decimal('jp_home_odds');
            $table->decimal('jp_draw_odds');
            $table->decimal('jp_away_odds');
            $table->boolean('jp_active')->default(true);
            $table->string('jp_market');
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
        Schema::dropIfExists('jackpots');
    }
};
