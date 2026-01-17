<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Developer
        User::create([
            'name' => 'Developer User',
            'email' => 'dev@example.com',
            'password' => Hash::make('password'),
            'role' => 'developer',
        ]);

        // Projects
        Project::create([
            'name' => 'Afaq App',
            'description' => 'A dashboard for monitoring work logs.',
        ]);

        Project::create([
            'name' => 'Legacy CRM',
            'description' => 'Maintenance of the old CRM system.',
        ]);
        
        Project::create([
            'name' => 'New E-commerce',
            'description' => 'Building a new shopify-like platform.',
        ]);
    }
}
