<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $table = 'company_profile';

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
        'whatsapp',
        'instagram',
        'facebook',
        'tiktok',
        'maps_embed',
        'logo_path',
        'operating_hours',
        'founded_year',
    ];

    public static function getInstance(): self
    {
        return self::firstOrCreate(['id' => 1], [
            'name' => 'Media Wisata',
            'description' => 'Perusahaan jasa perjalanan wisata dan transportasi',
        ]);
    }

    public function getLogoUrlAttribute(): string
    {
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            return asset('storage/' . $this->logo_path);
        }
        return asset('images/logo-media-wisata.png');
    }
}