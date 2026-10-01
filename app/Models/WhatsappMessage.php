<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    /**
     * Format phone to international Tanzania 255 format.
     */
    public static function formatPhone(string $phone): string
    {
        $digits = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($digits, '0')) {
            $digits = '255'.substr($digits, 1);
        } elseif (str_starts_with($digits, '+255')) {
            $digits = substr($digits, 1);
        }

        return $digits;
    }

    /**
     * Generate direct WhatsApp click-to-chat URL.
     */
    public function getWhatsappUrlAttribute(): string
    {
        $phone = self::formatPhone($this->recipient_phone);

        return 'https://api.whatsapp.com/send?phone='.$phone.'&text='.urlencode($this->message);
    }
}
