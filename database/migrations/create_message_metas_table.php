<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('message_metas', function (Blueprint $table) {

            $table->id();

            // Relation to messages table
            $table->unsignedBigInteger('ref_parent');

            // Meta key-value
            $table->string('meta_key');
            $table->text('meta_value')->nullable();

            // Optional status field
            $table->string('status')->nullable();

            // Optional audit fields
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();

            $table->timestamps();

            // Optional foreign key (good practice)
            $table->foreign('ref_parent')
                  ->references('id')
                  ->on('messages')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_metas');
    }
};