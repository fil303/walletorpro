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
        Schema::create('stake_segments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("stake_plan_id");
            $table->integer("duration");
            $table->tinyText("interest");
            $table->timestamps();

            $table->index("stake_plan_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stake_segments');
    }
};
