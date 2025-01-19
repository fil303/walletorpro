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
        Schema::create('coin_cap_market_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("coin_id");
            $table->string("coin_name", 40);
            $table->string("coin_code", 15);
            $table->integer("coin_rank");
            $table->unsignedDecimal("coin_price", 19, 8)->default(0);
            $table->unsignedDecimal("volume", 29, 8)->default(0);
            $table->decimal("change_24h", 19, 8)->default(0);
            $table->boolean("is_fiat")->default(0);
            $table->string("token_address")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_cap_market_prices');
    }
};
