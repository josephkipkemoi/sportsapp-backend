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
        Schema::create('checkout_carts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('session_id');
            $table->bigInteger('user_id');
            $table->bigInteger('stake_amount');
            $table->decimal('total_odds');
            $table->float('final_payout');
            $table->string('betslip_status')->default('Active');
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
        Schema::dropIfExists('checkout_carts');
    }
};
