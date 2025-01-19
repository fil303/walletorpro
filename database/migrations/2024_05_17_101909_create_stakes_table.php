<?php

use App\Enums\StakingStatus;
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
        Schema::create('stakes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("coin_id");
            $table->unsignedInteger("stake_plan_id");
            $table->unsignedInteger("stake_segment_id");
            $table->string("coin", 15);
            $table->integer("duration");
            $table->unsignedDecimal("interest", 29, 20);
            $table->unsignedDecimal("amount", 29, 20);
            $table->unsignedDecimal("interest_amount", 29, 20);
            $table->boolean("auto_stake")->default(false);
            $table->string("status", 10)->default(enum(StakingStatus::IMMATURE));
            $table->dateTime("end_at");
            $table->timestamps();

            $table->index(["coin_id"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stakes');
    }
};
