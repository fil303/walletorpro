<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buy_crypto_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('receive_coin_id');
            $table->unsignedInteger('spend_coin_id');
            $table->string('receive_coin', 15);
            $table->string('spend_coin', 15);
            $table->unsignedDecimal("amount", 29, 20)->default(0);
            $table->unsignedDecimal("spend_amount", 29, 20)->default(0);
            $table->unsignedInteger("fees")->default(0);
            $table->unsignedDecimal("rate", 29, 20)->default(0);
            $table->boolean("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_crypto_transactions');
    }
};
