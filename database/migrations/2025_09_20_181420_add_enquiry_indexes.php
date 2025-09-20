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
        Schema::table('enquiries', function (Blueprint $table) {
            $table->index(['resource_id', 'preferred_date', 'status'], 'enquiries_resource_date_status_index');
            $table->index(['status', 'created_at'], 'enquiries_status_created_index');
            $table->index(['preferred_date', 'created_at'], 'enquiries_date_created_index');
            $table->index(['expires_at', 'status'], 'enquiries_expires_status_index');
        });

        Schema::table('calendar_sync_logs', function (Blueprint $table) {
            $table->index(['status', 'retry_count', 'created_at'], 'sync_logs_status_retry_created_index');
            $table->index(['event_type', 'sync_direction', 'status'], 'sync_logs_event_direction_status_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table) {
            $table->dropIndex('enquiries_resource_date_status_index');
            $table->dropIndex('enquiries_status_created_index');
            $table->dropIndex('enquiries_date_created_index');
            $table->dropIndex('enquiries_expires_status_index');

            if (config('database.default') === 'mysql') {
                $table->dropIndex('enquiries_customer_search_index');
            }
        });

        Schema::table('calendar_sync_logs', function (Blueprint $table) {
            $table->dropIndex('sync_logs_status_retry_created_index');
            $table->dropIndex('sync_logs_event_direction_status_index');
        });
    }
};
