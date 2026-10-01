<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function wallet(): HasOne
    {
        return $this->hasOne(CustomerWallet::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    public function whatsappMessages(): HasMany
    {
        return $this->hasMany(WhatsappMessage::class);
    }

    /**
     * Get or create wallet for customer.
     */
    public function getOrCreateWallet(): CustomerWallet
    {
        return $this->wallet()->firstOrCreate([
            'tenant_id' => $this->tenant_id,
        ], [
            'balance' => 0,
            'is_active' => true,
        ]);
    }
}
