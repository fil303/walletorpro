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
        Schema::create('wallet_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('coin_id');
            $table->unsignedInteger('wallet_id');
            $table->string('coin', 15);
            $table->string('code', 15)->nullable();
            $table->string('address', 100)->unique();
            $table->string('memo', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_addresses');
    }
};
