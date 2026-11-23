<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'type',
        'method',
        'amount',
        'status',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'midtrans_payment_type',
        'midtrans_va_number',
        'payment_proof',
        'verified_by',
        'verified_at',
        'payment_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'verified_at' => 'datetime',
        'payment_date' => 'datetime',
    ];

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopePendingVerification($query)
    {
        return $query->where('type', 'pelunasan')
            ->where('method', 'manual_transfer')
            ->where('status', 'pending');
    }

    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->amount, 0, ',', '.');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'success' => '<span class="badge badge-success">Sukses</span>',
            'failed' => '<span class="badge badge-danger">Gagal</span>',
            'verified' => '<span class="badge badge-success">Terverifikasi</span>',
            default => '<span class="badge badge-light">' . $this->status . '</span>',
        };
    }

    public function getPaymentProofUrlAttribute(): ?string
    {
        if ($this->payment_proof && Storage::disk('public')->exists($this->payment_proof)) {
            return asset('storage/' . $this->payment_proof);
        }
        return null;
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'dp' => 'Down Payment (DP)',
            'pelunasan' => 'Pelunasan',
            default => ucfirst($this->type),
        };
    }

    public function getMethodLabelAttribute(): string
    {
        return match ($this->method) {
            'midtrans' => 'Midtrans (Online)',
            'manual_transfer' => 'Transfer Manual',
            default => ucfirst($this->method),
        };
    }

    public function isDp(): bool
    {
        return $this->type === 'dp';
    }

    public function isPelunasan(): bool
    {
        return $this->type === 'pelunasan';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isVerified(): bool
    {
        return in_array($this->status, ['verified', 'success']);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}