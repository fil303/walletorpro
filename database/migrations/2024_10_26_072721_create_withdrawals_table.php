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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("coin_id");
            $table->unsignedBigInteger("wallet_id");
            $table->unsignedTinyInteger("type")->default(1);
            $table->string("coin", 15);
            $table->string("code", 15);
            $table->unsignedDecimal("amount", 29, 20)->default(0);
            $table->unsignedDecimal("fees", 29, 20)->default(0);
            $table->string("to_address", 100);
            $table->string("trx")->nullable();
            $table->unsignedTinyInteger("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
