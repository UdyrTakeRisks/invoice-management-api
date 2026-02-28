<?php

namespace Database\Factories;

use App\Enums\PaymentMethodEnum;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::inRandomOrder()->first()->id ?? Invoice::factory()->create()->id,
            'amount' => fake()->randomFloat(2, 99.99, 4999.99),
            'payment_method' => fake()->randomElement(PaymentMethodEnum::cases()),
            'reference_number' => Str::random(20),
            'paid_at' => fake()->date()

        ];
    }
}
