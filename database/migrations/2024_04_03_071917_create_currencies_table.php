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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code',10)->unique();
            $table->string('symbol',10);
            $table->decimal('rate',19,2)->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('primary')->default(0);
            $table->timestamps();

            $table->index("code");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
