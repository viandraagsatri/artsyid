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
        Schema::create('order_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->unsignedTinyInteger('step_order')->default(1);
            $table->string('stage_name', 100);
            $table->enum('status', ['pending', 'review', 'approved', 'revision', 'completed'])->default('pending');
            $table->string('watermarked_image_url')->nullable();
            $table->string('final_file_url')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_tracks');
    }
};
