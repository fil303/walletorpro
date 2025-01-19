<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * if need rollback - migrate:rollback --path=/database/migrations/2024_02_27_053732_create_faqs_table.php
     */
    public function up(): void
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('uid', 30)->unique();
            $table->string("page", 30);
            $table->string("question", 120);
            $table->string("answer", 255);
            $table->string("lang", 5)->default("en");
            $table->boolean("status")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
