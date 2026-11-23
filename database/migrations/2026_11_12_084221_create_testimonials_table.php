<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->text('message');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->boolean('is_approved')->default(false);
            $table->timestamps();

            $table->index(['is_approved', 'rating']);
            $table->index('booking_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};