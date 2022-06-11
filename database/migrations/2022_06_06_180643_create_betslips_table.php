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
        Schema::create('betslips', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('fixture_id');
            $table->bigInteger('session_id');
            $table->string('betslip_teams');
            $table->string('betslip_market');
            $table->string('betslip_picked');
            $table->string('betslip_odds');
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
        Schema::dropIfExists('betslips');
    }
};
