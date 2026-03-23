<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {

            $table->id();

            // Core identifiers
            $table->integer('channel_id');
            $table->integer('integration_id');

            // Unique identifier (IMAP UID / SMTP UUID)
            $table->string('message_id')->unique();

            // Email data
            $table->string('from');
            $table->string('to');
            $table->string('message_type')->nullable();
            $table->text('content')->nullable();

            // Timestamp from email (not Laravel timestamps)
            $table->timestamp('timestamp')->nullable();

            // Status: sent / received
            $table->string('status')->nullable();

            // Raw payload (optional, no duplication with metas)
            $table->longText('raw_payload')->nullable();

            // Optional audit fields
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};