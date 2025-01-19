<?php

use App\Enums\CryptoProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->string("provider", 20)->nullable(); // enum(CryptoProvider::COINPAYMENT)
            $table->string("type", 1)->default("c"); // c = crypto, f = fiat
            $table->string("name", 50);
            $table->string("code", 15)->unique();
            $table->string("coin", 15);
            $table->string("symbol", 5)->nullable();
            $table->unsignedTinyInteger("decimal")->default(18);
            $table->unsignedTinyInteger("print_decimal")->default(8);
            $table->unsignedDecimal("rate", 29, 18)->default(0);
            $table->boolean("has_network")->default(false);
            $table->string("network", 100)->nullable();
            $table->string("icon", 100)->nullable();
            $table->boolean("status")->default(1);
            $table->unsignedDecimal("withdrawal_fees", 29, 20)->default(0);
            $table->unsignedTinyInteger("withdrawal_fees_type")->default(1); // 1 = fixed, 2 = percentage
            $table->unsignedDecimal("exchange_fees", 29, 20)->default(0);
            $table->unsignedTinyInteger("exchange_fees_type")->default(1); // 1 = fixed, 2 = percentage
            $table->boolean("exchange_status")->default(1);
            $table->boolean("buy_status")->default(1);
            $table->boolean("withdrawal_status")->default(1);
            $table->unsignedDecimal("withdrawal_min", 29, 20)->default(0.00001);
            $table->unsignedDecimal("withdrawal_max", 29, 20)->default(9999999);
            $table->timestamps();

            $table->index(["uid","code","coin"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coins');
    }
};
