<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
  
    Category::factory(10)->create();

    
    User::factory(20)->create()->each(function ($user) {
        if ($user->is_employer) {
            Profile::factory()->employer()->create([
                'user_id' => $user->id
            ]);
        } else {
            Profile::factory()->candidate()->create([
                'user_id' => $user->id
            ]);
        }
});

    
    Listing::factory(30)->create();

    
    for ($i = 0; $i < 50; $i++) {
    try {
        Application::factory()->create();
    } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
        // Se becca un duplicato, lo ignora e passa al prossimo ciclo
        continue;
    }
}

    
    $skills = ['PHP', 'Laravel', 'Vue', 'React', 'SQL'];
    foreach($skills as $s) { 
        \App\Models\Skill::firstOrCreate(['name' => $s]); 
    }

   
    Listing::all()->each(function ($listing) {
        $listing->skills()->attach(
            \App\Models\Skill::inRandomOrder()->limit(3)->pluck('id')
        );
    });
    }
    
}
