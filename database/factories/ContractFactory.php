<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contract>
 */
class ContractFactory extends Factory
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
            'contract_number' => 'CNT-'.fake()->unique()->numerify('2026-#####'),
            'title' => fake()->randomElement(['Retail POS Annual License', 'Wholesale Multi-Branch Lease', 'Enterprise Cloud Tier', 'Starter Tier Subscription']),
            'type' => fake()->randomElement(['lease', 'subscription', 'custom_license']),
            'billing_cycle' => fake()->randomElement(['monthly', 'annually']),
            'amount' => fake()->randomElement([350000, 750000, 1200000, 2400000]),
            'currency' => 'TZS',
            'start_date' => now()->subMonths(fake()->numberBetween(1, 6)),
            'end_date' => now()->addMonths(fake()->numberBetween(6, 18)),
            'status' => 'active',
            'payment_status' => 'paid',
            'sla_terms' => '99.9% uptime SLA with 24/7 technical helpdesk and automated cloud backups.',
            'notes' => fake()->sentence(),
        ];
    }
}
