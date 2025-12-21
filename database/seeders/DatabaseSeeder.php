<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Required default admin for the assignment (works with migrate:fresh --seed)
        User::updateOrCreate(
            ['email' => 'admin@ehb.be'],
            [
                'name' => 'admin',
                'password' => Hash::make('Password!321'),
                'is_admin' => true,
            ]
        );

        // Optional dev/test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(NewsSeeder::class);
    }
}
