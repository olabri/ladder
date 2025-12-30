<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'olav+admin@jaggu.org',
            'is_admin' => true,
        ]);

        User::factory()->create([
            'name' => 'Test Spiller',
            'email' => 'test@example.com',
        ]);
    }
}
