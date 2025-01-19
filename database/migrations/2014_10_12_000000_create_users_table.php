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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique();
            $table->string('first_name',30);
            $table->string('last_name',30);
            $table->string('name',50);
            $table->string('username',30)->unique();
            $table->string('email',100)->unique();
            $table->unsignedTinyInteger('role')->default(3);
            $table->unsignedInteger('role_id')->nullable();
            $table->string('country',2)->nullable();
            $table->string('phone',60)->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_token', 32)->nullable();
			$table->string('phone_token', 32)->nullable();
            $table->string('password');
            $table->string('image', 200)->nullable();
            $table->string('language',3)->nullable();
            $table->string('status', 10)->default(1);
            $table->string('google_2fa_secret', 30)->nullable();
            $table->boolean('google_2fa')->default(false);
            $table->boolean('email_2fa')->default(false);
            $table->boolean('phone_2fa')->default(false);
            $table->integer('pin_code')->default(0);
            $table->dateTime('last_login')->nullable();
            $table->string('password_reset_token', 32)->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();

            // indexs
            $table->index(["email"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
