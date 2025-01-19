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
        Schema::create('stake_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("coin_id");
            $table->string("coin", 15);
            $table->tinyText("min");
            $table->tinyText("max");
            $table->boolean("status")->default(true);
            $table->timestamps();

            $table->index(["coin_id","coin"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stake_plans');
    }
};
