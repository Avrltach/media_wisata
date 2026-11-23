<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->string('booking_code', 30)->unique();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 20);
            $table->string('whatsapp', 20);
            $table->date('departure_date');
            $table->integer('number_of_participants')->default(1);
            $table->decimal('total_price', 12, 2);
            $table->decimal('dp_amount', 12, 2);
            $table->decimal('pelunasan_amount', 12, 2);
            $table->enum('status', [
                'pending_dp',
                'dp_paid',
                'awaiting_pelunasan',
                'lunas',
                'selesai',
                'cancelled',
            ])->default('pending_dp');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['package_id', 'status']);
            $table->index('booking_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};