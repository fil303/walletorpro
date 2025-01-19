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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("coin_id");
            $table->unsignedBigInteger("wallet_id");
            $table->unsignedTinyInteger("type")->default(1);
            $table->string("coin", 15);
            $table->string("code", 15);
            $table->unsignedDecimal("amount", 29, 18)->default(0);
            $table->string("trx")->nullable();
            $table->string("from_address", 100);
            $table->unsignedTinyInteger("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
