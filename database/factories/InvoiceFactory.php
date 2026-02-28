<?php

namespace Database\Factories;

use App\Enums\InvoiceStatusEnum;
use App\Models\Contract;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tenantId = Tenant::inRandomOrder()->first()->id ?? Tenant::factory()->create()->id;
        $paddedTenantId = str_pad($tenantId, 3, '0', STR_PAD_LEFT);
        $yearMonth = now()->format('Ym');
        $sequence = fake()->randomNumber(4);
        $paddedSequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);
    
        return [
            'contract_id' => Contract::inRandomOrder()->first()->id ?? Contract::factory()->create()->id,
            'invoice_number' => 'INV-'. $paddedTenantId. '-'. $yearMonth. '-'. $paddedSequence,
            'subtotal' => fake()->randomFloat(2, 99.99, 6999.99),
            'tax_amount' => fake()->randomFloat(2, 99.99, 2999.99),
            'total' => fake()->randomFloat(2, 99.99, 9999.99),
            'status' => fake()->randomElement(InvoiceStatusEnum::cases()),
            'due_date' => fake()->date(),
            'paid_at' => fake()->date()
        ];
    }
}
