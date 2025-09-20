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
        Schema::create('calendar_sync_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enquiry_id')->constrained()->cascadeOnDelete();
            $table->string('event_type');
            $table->string('microsoft_event_id')->nullable();
            $table->string('sync_direction');
            $table->enum('status', ['success', 'failed', 'pending', 'retry']);
            $table->json('request_data')->nullable();
            $table->json('response_data')->nullable();
            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();

            $table->index(['enquiry_id', 'event_type']);
            $table->index(['status', 'created_at']);
            $table->index('microsoft_event_id');
            $table->index(['sync_direction', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_sync_logs');
    }
};
