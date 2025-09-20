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
        Schema::create('microsoft_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('user_identifier')->unique();
            $table->text('access_token');
            $table->text('refresh_token');
            $table->string('token_type')->default('Bearer');
            $table->integer('expires_in');
            $table->timestamp('expires_at');
            $table->json('scope')->nullable();
            $table->string('tenant_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_refreshed_at')->nullable();
            $table->timestamps();

            $table->index(['user_identifier', 'is_active']);
            $table->index('expires_at');
            $table->index(['is_active', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('microsoft_tokens');
    }
};
