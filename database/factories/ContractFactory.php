<?php

namespace Database\Factories;

use App\Enums\ContractStatusEnum;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contract>
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
            'tenant_id' =>  Tenant::inRandomOrder()->first()->id ?? Tenant::factory()->create()->id,
            'unit_name' => fake()->name(),
            'customer_name' => fake()->name(),
            'rent_amount' => fake()->randomFloat(2, 99.99, 9999.99),
            'start_date' => fake()->date(),
            'end_date' => fake()->date(),
            'status' => fake()->randomElement(ContractStatusEnum::cases())
        ];
    }
}
