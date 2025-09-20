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
        Schema::create('enquiry_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enquiry_id')->constrained()->cascadeOnDelete();
            $table->string('previous_status')->nullable();
            $table->string('new_status');
            $table->string('changed_by')->nullable();
            $table->string('change_reason')->nullable();
            $table->json('metadata')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['enquiry_id', 'created_at']);
            $table->index(['new_status', 'created_at']);
            $table->index('changed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enquiry_status_history');
    }
};
