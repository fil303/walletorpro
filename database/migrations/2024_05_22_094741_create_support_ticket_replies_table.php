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
        Schema::create('support_ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->string("ticket", 30);
            $table->unsignedInteger("sender");
            $table->unsignedInteger("receiver")->nullable();
            $table->text("message")->nullable();
            $table->json("attachment")->nullable();
            $table->timestamps();

            $table->index("ticket");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_ticket_replies');
    }
};
