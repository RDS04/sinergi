<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Invitation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user with safe method
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Generate 1000 dummy invitation data
        $this->seedInvitations();
    }

    /**
     * Seed 1000 dummy invitation records for performance testing
     */
    private function seedInvitations(): void
    {
        $faker = Faker::create('id_ID');
        $statuses = ['mahasiswa', 'alumni', 'ortu'];
        
        $batch = [];
        $batchSize = 100;
        
        for ($i = 1; $i <= 1000; $i++) {
            $batch[] = [
                'nama_mhs' => $faker->name(),
                'status' => $faker->randomElement($statuses),
                'wa_mhs' => '62' . $faker->numerify('##########'),
                'attendance_status' => 'belum_hadir',
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Insert batch every 100 records
            if (count($batch) === $batchSize || $i === 1000) {
                Invitation::insert($batch);
                $this->command->info("Inserted {$i} records...");
                $batch = [];
            }
        }

        $this->command->info('✅ Successfully created 1000 dummy invitation records!');
    }
}
