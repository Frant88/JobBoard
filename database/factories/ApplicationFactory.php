<?php

namespace Database\Factories;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           // Sceglie un annuncio a caso tra quelli esistenti
            'listing_id' => Listing::inRandomOrder()->first()->id ?? Listing::factory(),
            
            // Sceglie un utente che NON sia un employer (quindi un candidato)
            'user_id' => User::where('is_employer', false)->inRandomOrder()->first()->id ?? User::factory(),
            
            'cover_letter' => fake()->paragraphs(2, true),
            'status' => fake()->randomElement(['pending', 'accepted', 'rejected']),
        ];
    }
}
