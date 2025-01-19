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
        Schema::create('coin_orders', function (Blueprint $table) {
            $table->id();
            $table->string("uid", 30)->unique();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("wallet_id");
            $table->unsignedBigInteger("coin_id");
            $table->unsignedBigInteger("currency_id");
            $table->unsignedBigInteger("payment_id");
            $table->string("transaction_id", 30)->unique();
            $table->string("coin", 15);
            $table->string("coin_code", 15);
            $table->string("currency_code", 5);
            $table->string("payment_slug", 20);
            $table->unsignedDecimal("rate", 29, 20)->default(0);
            $table->unsignedDecimal("amount", 29, 20)->default(0);
            $table->unsignedDecimal("fees", 29, 20)->default(0);
            $table->unsignedDecimal("net_price", 29, 20)->default(0);
            $table->unsignedDecimal("total_price", 29, 20)->default(0);
            $table->unsignedTinyInteger("status")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_orders');
    }
};
