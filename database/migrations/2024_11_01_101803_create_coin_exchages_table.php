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
        Schema::create('coin_exchanges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('from_coin_id');
            $table->unsignedBigInteger('to_coin_id');
            $table->string('from_coin', 15);
            $table->string('to_coin', 15);
            $table->unsignedDecimal('fee', 29, 20)->default(0);
            $table->unsignedDecimal('rate', 29, 20)->default(0);
            $table->unsignedDecimal('from_amount', 29, 20)->default(0);
            $table->unsignedDecimal('to_amount', 29, 20)->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coin_exchages');
    }
};
