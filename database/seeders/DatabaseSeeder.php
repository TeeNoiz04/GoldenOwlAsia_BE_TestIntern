<?php

namespace Database\Seeders;

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
        $studentCount = \App\Models\Student::count();
        
        if ($studentCount > 0) {
            $this->command->info("⚠️  Database already has {$studentCount} students. Skipping seed.");
            return;
        }
        
        $this->command->info('🌱 Starting database seeding...');
        $this->call([
            StudentSeeder::class,
        ]);
        $this->command->info('✅ Database seeding completed!');
    }
}
