<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'settings' => 'array',
    ];

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function activeContract()
    {
        return $this->hasOne(Contract::class)->where('status', 'active')->latestOfMany();
    }

    public function supportTickets(): HasMany
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class);
    }

    public function riders(): HasMany
    {
        return $this->hasMany(Rider::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    public function customerWallets(): HasMany
    {
        return $this->hasMany(CustomerWallet::class);
    }

    public function isSupplier(): bool
    {
        return in_array($this->business_type, ['supplier', 'hybrid'], true);
    }

    public function isRetailer(): bool
    {
        return in_array($this->business_type, ['retailer', 'hybrid'], true);
    }

    /**
     * Check if a specific feature is enabled for this tenant.
     */
    public function hasFeature(string $featureKey): bool
    {
        $settings = $this->settings ?? [];

        // By default, essential features are enabled if not explicitly disabled
        return (bool) ($settings['features'][$featureKey] ?? true);
    }

    /**
     * Enable or disable a feature for this tenant.
     */
    public function setFeature(string $featureKey, bool $enabled): void
    {
        $settings = $this->settings ?? [];
        $settings['features'][$featureKey] = $enabled;
        $this->settings = $settings;
        $this->save();
    }
}
