<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'phone' => fake()->phoneNumber(),
            'website_url' => fake()->url(),
            'bio' => fake()->sentence(20),
        ];
    }

    public function candidate(): static
    {
        return $this->state(fn (array $attributes) => [
            'cv_path' => 'cv/' . fake()->uuid() . '.pdf',
            'github_url' => 'https://github.com/' . fake()->userName(),
            'linkedin_url' => 'https://linkedin.com/in/' . fake()->userName(),
            // Lasciamo nulli i campi aziendali
            'company_name' => null,
            'vat_number' => null,
            'logo_path' => null,
        ]);
    }

    public function employer(): static
    {
        return $this->state(fn (array $attributes) => [
            'company_name' => fake()->company(),
            'vat_number' => fake()->numerify('###########'),
            'logo_path' => 'logos/company-' . fake()->numberBetween(1, 10) . '.png',
            'address' => fake()->address(),
            // Lasciamo nulli i campi per programmatori
            'cv_path' => null,
            'github_url' => null,
        ]);
    }
}
