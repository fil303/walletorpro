<?php

use App\Enums\SupportTicketStatus;
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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id");
            $table->integer("ticket")->unique();
            $table->string("subject", 150);
            $table->string("status", 10)->default(enum(SupportTicketStatus::OPEN));
            $table->string("priority", 6);
            $table->timestamps();

            $table->index("ticket");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
