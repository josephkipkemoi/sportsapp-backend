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
        Schema::create('custom_fixtures', function (Blueprint $table) {
            $table->id();
            $table->integer('fixture_id');
            $table->string('fixture_date');
            $table->string('league_name');
            $table->string('country');
            $table->string('home');
            $table->string('away');
            $table->string('logo')->nullable();
            $table->string('flag')->nullable();
            $table->string('league_round')->nullable();
            $table->text('odds')->nullable();
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
        Schema::dropIfExists('custom_fixtures');
    }
};
