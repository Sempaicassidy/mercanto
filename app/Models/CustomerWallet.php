<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerWallet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'balance' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id');
    }

    /**
     * Credit / Deposit money into wallet.
     */
    public function deposit(float $amount, string $description = 'Deposit', ?string $reference = null, ?int $userId = null): WalletTransaction
    {
        $this->balance += $amount;
        $this->save();

        return $this->transactions()->create([
            'tenant_id' => $this->tenant_id,
            'customer_id' => $this->customer_id,
            'type' => 'deposit',
            'amount' => $amount,
            'balance_after' => $this->balance,
            'reference' => $reference,
            'description' => $description,
            'performed_by' => $userId,
        ]);
    }

    /**
     * Debit / Spend money from wallet.
     */
    public function debit(float $amount, string $description = 'Purchase Payment', ?string $reference = null, ?int $userId = null): WalletTransaction
    {
        if ($this->balance < $amount) {
            throw new \RuntimeException('Salio la pochi halitoshi / Insufficient wallet balance.');
        }

        $this->balance -= $amount;
        $this->save();

        return $this->transactions()->create([
            'tenant_id' => $this->tenant_id,
            'customer_id' => $this->customer_id,
            'type' => 'purchase_debit',
            'amount' => $amount,
            'balance_after' => $this->balance,
            'reference' => $reference,
            'description' => $description,
            'performed_by' => $userId,
        ]);
    }
}
