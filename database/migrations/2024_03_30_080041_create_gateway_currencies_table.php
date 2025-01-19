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
        Schema::create('gateway_currencies', function (Blueprint $table) {
            $table->id();
            $table->string("payment_gateway_uid", 30);
            $table->string("currency_code", 10);
            $table->decimal("min_amount", 19, 8)->default(0);
            $table->decimal("max_amount", 19, 8)->default(0);
            $table->decimal("fees", 19, 8)->default(0);
            $table->unsignedTinyInteger("fees_type")->default(1);
            $table->timestamps();

            $table->index("payment_gateway_uid");
            $table->index("currency_code");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_currencies');
    }
};
