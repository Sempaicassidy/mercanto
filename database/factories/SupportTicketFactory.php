<?php

namespace Database\Factories;

use App\Models\SupportTicket;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SupportTicket>
 */
class SupportTicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'user_id' => null,
            'ticket_number' => 'TCK-'.fake()->unique()->numerify('2026-#####'),
            'subject' => fake()->randomElement([
                'Kushindwa kuunganisha mashine ya risiti (POS Printer)',
                'Maombi ya kuongeza tawi jipya la Mbezi Beach',
                'Kurekebisha kiwango cha kodi ya VAT (18%)',
                'Upatikanaji wa ripoti ya hesabu ya stoo ya mwisho wa mwezi',
                'Kusasisha nenosiri la muuzaji (Cashier)',
            ]),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement(['technical', 'billing', 'pos_hardware', 'feature_request', 'training']),
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'urgent']),
            'status' => fake()->randomElement(['open', 'in_progress', 'resolved']),
            'assigned_to' => null,
            'resolution_notes' => null,
        ];
    }
}
