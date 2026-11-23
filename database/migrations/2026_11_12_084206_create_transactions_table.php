<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['dp', 'pelunasan']);
            $table->enum('method', ['midtrans', 'manual_transfer']);
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending', 'success', 'failed', 'verified'])->default('pending');
            $table->string('midtrans_order_id', 50)->nullable();
            $table->string('midtrans_transaction_id', 50)->nullable();
            $table->string('midtrans_payment_type', 30)->nullable();
            $table->string('midtrans_va_number', 50)->nullable();
            $table->string('payment_proof')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();

            $table->index(['booking_id', 'type']);
            $table->index('status');
            $table->index('midtrans_order_id');
            $table->index('verified_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};