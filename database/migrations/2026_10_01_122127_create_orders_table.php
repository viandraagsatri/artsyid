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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->foreignId('client_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('artist_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('commission_menu_id')->constrained('commission_menus')->restrictOnDelete();
            $table->text('concept_description');
            $table->string('vibes')->nullable();
            $table->string('background_type', 100)->nullable();
            $table->integer('character_count')->default(1);
            $table->enum('request_type', ['custom', 'instant']);
            $table->enum('status', [
                'pending_review', 'rejected', 'awaiting_dp', 'on_progress',
                'review', 'revision', 'awaiting_final_payment', 'completed'
            ])->default('pending_review');
            $table->text('rejection_reason')->nullable();
            $table->decimal('base_amount', 12, 2);
            $table->decimal('addons_amount', 12, 2)->default(0.00);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('dp_amount', 12, 2);
            $table->decimal('final_amount', 12, 2);
            $table->dateTime('deadline_at')->nullable();
            $table->timestamps();

            $table->index('status');
            $table->index('client_id');
            $table->index('artist_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
