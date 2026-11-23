<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'package_id',
        'booking_code',
        'full_name',
        'email',
        'phone',
        'whatsapp',
        'departure_date',
        'number_of_participants',
        'total_price',
        'dp_amount',
        'pelunasan_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'total_price' => 'decimal:2',
        'dp_amount' => 'decimal:2',
        'pelunasan_amount' => 'decimal:2',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Booking $booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = self::generateBookingCode();
            }

            if (!empty($booking->total_price)) {
                if (empty($booking->dp_amount)) {
                    $booking->dp_amount = $booking->total_price * 0.30;
                }
                if (empty($booking->pelunasan_amount)) {
                    $booking->pelunasan_amount = $booking->total_price - $booking->dp_amount;
                }
            }
        });
    }

    public static function generateBookingCode(): string
    {
        $prefix = 'MW-' . now()->format('Ymd') . '-';
        $lastBooking = self::where('booking_code', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = 1;
        if ($lastBooking) {
            $lastNumber = (int) substr($lastBooking->booking_code, -3);
            $nextNumber = $lastNumber + 1;
        }

        return $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }

    public function scopeForCustomer($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getFormattedTotalPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->total_price, 0, ',', '.');
    }

    public function getFormattedDpAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->dp_amount, 0, ',', '.');
    }

    public function getFormattedPelunasanAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->pelunasan_amount, 0, ',', '.');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending_dp' => '<span class="badge badge-warning">Menunggu DP</span>',
            'dp_paid' => '<span class="badge badge-info">DP Lunas</span>',
            'awaiting_pelunasan' => '<span class="badge badge-primary">Menunggu Verifikasi</span>',
            'lunas' => '<span class="badge badge-success">Lunas</span>',
            'selesai' => '<span class="badge badge-secondary">Selesai</span>',
            'cancelled' => '<span class="badge badge-danger">Dibatalkan</span>',
            default => '<span class="badge badge-light">' . $this->status . '</span>',
        };
    }

    public function isDpPaid(): bool
    {
        return in_array($this->status, ['dp_paid', 'awaiting_pelunasan', 'lunas', 'selesai']);
    }

    public function isLunas(): bool
    {
        return in_array($this->status, ['lunas', 'selesai']);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(BookingParticipant::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function dpTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->where('type', 'dp')->latest();
    }

    public function pelunasanTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class)->where('type', 'pelunasan')->latest();
    }

    public function testimonial(): HasOne
    {
        return $this->hasOne(Testimonial::class);
    }
}