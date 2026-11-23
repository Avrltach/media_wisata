<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'price',
        'duration',
        'location',
        'included_facilities',
        'excluded_facilities',
        'itinerary',
        'main_image',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Package $package) {
            if (empty($package->slug)) {
                $package->slug = Str::slug($package->name) . '-' . Str::lower(Str::random(6));
            }
        });

        static::updating(function (Package $package) {
            if ($package->isDirty('name') && !$package->isDirty('slug')) {
                $package->slug = Str::slug($package->name) . '-' . Str::lower(Str::random(6));
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }

    public function getIncludedFacilitiesArrayAttribute(): array
    {
        if (empty($this->included_facilities)) return [];
        return array_filter(array_map('trim', explode("\n", $this->included_facilities)));
    }

    public function getExcludedFacilitiesArrayAttribute(): array
    {
        if (empty($this->excluded_facilities)) return [];
        return array_filter(array_map('trim', explode("\n", $this->excluded_facilities)));
    }

    public function getItineraryArrayAttribute(): array
    {
        if (empty($this->itinerary)) return [];
        return array_filter(array_map('trim', explode("\n", $this->itinerary)));
    }

    public function getMainImageUrlAttribute(): string
    {
        if ($this->main_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($this->main_image)) {
            return asset('storage/' . $this->main_image);
        }
        return asset('images/default-package.jpg');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PackageImage::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}