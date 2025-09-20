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
        Schema::create('enquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->constrained()->cascadeOnDelete();
            $table->date('preferred_date');
            $table->time('preferred_start_time')->nullable();
            $table->time('preferred_end_time')->nullable();
            $table->json('customer_info');
            $table->text('message')->nullable();
            $table->enum('status', ['pending', 'approved', 'declined', 'cancelled'])->default('pending');
            $table->string('enquiry_token')->unique();
            $table->string('microsoft_event_id');
            $table->string('microsoft_calendar_id');
            $table->json('microsoft_event_data');
            $table->timestamp('calendar_synced_at');
            $table->boolean('calendar_sync_enabled');
            $table->string('calendar_sync_status');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['resource_id', 'status']);
            $table->index(['preferred_date', 'status']);
            $table->index('enquiry_token');
            $table->index('status');
            $table->index('microsoft_event_id');
            $table->index(['calendar_sync_status', 'calendar_sync_enabled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropIndex(['microsoft_event_id']);
            $table->dropIndex(['calendar_sync_status', 'calendar_sync_enabled']);

            $table->dropColumn([
                'microsoft_event_id',
                'microsoft_calendar_id',
                'microsoft_event_data',
                'calendar_synced_at',
                'calendar_sync_enabled',
                'calendar_sync_status'
            ]);
        });

        Schema::dropIfExists('enquiries');
    }
};
