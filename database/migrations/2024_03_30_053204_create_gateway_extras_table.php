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
        Schema::create('gateway_extras', function (Blueprint $table) {
            $table->id();
            $table->string("payment_gateway_uid");
            $table->string("title", 100);
            $table->string("slug", 100);
            $table->string("value", 200)->nullable();
            $table->string("type", 10);
            $table->boolean("required")->default(true);
            $table->boolean("readonly")->default(false);
            $table->timestamps();

            $table->index("payment_gateway_uid");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_extras');
    }
};
