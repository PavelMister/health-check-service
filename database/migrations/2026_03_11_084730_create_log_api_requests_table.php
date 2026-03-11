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
        Schema::create('log_api_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('owner_uuid')->nullable()->index();
            $table->string('method', 10);
            $table->string('path');
            $table->json('payload')->nullable();
            $table->integer('status_code');
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->decimal('duration_ms', 10, 2)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_api_requests');
    }
};
