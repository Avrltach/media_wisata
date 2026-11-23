<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('category', ['paket_wisata', 'event_organizer', 'sewa_transport'])->default('paket_wisata');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->string('duration');
            $table->string('location');
            $table->text('included_facilities')->nullable();
            $table->text('excluded_facilities')->nullable();
            $table->text('itinerary')->nullable();
            $table->string('main_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->index(['category', 'is_active']);
            $table->index('is_featured');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};