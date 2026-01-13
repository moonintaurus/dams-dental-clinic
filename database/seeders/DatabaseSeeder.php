<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dentist;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'damsdentalclinic@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '09171234567',
        ]);

        // Create Sample Dentists
        Dentist::create([
            'name' => 'Dr. Maria Santos',
            'specialization' => 'General Dentistry',
            'phone' => '09171234568',
            'schedule' => [
                'monday' => ['09:00-17:00'],
                'tuesday' => ['09:00-17:00'],
                'wednesday' => ['09:00-17:00'],
                'thursday' => ['09:00-17:00'],
                'friday' => ['09:00-17:00'],
            ]
        ]);

        Dentist::create([
            'name' => 'Dr. Juan Reyes',
            'specialization' => 'Orthodontics',
            'phone' => '09171234569',
            'schedule' => [
                'monday' => ['09:00-17:00'],
                'tuesday' => ['09:00-17:00'],
                'wednesday' => ['09:00-17:00'],
                'thursday' => ['09:00-17:00'],
                'friday' => ['09:00-17:00'],
            ]
        ]);

        // Create Services
        $services = [
            ['name' => 'General Cleaning', 'description' => 'Professional teeth cleaning', 'price' => 800, 'duration' => 30],
            ['name' => 'Tooth Extraction', 'description' => 'Safe tooth removal', 'price' => 1500, 'duration' => 45],
            ['name' => 'Root Canal', 'description' => 'Root canal treatment', 'price' => 5000, 'duration' => 90],
            ['name' => 'Braces Consultation', 'description' => 'Initial braces assessment', 'price' => 500, 'duration' => 30],
            ['name' => 'Teeth Whitening', 'description' => 'Professional whitening', 'price' => 3000, 'duration' => 60],
            ['name' => 'Dental Filling', 'description' => 'Cavity filling', 'price' => 1200, 'duration' => 45],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Create Sample Patient
        User::create([
            'name' => 'Juan Dela Cruz',
            'email' => 'patient@example.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
            'phone' => '09171234570',
            'address' => 'Sta. Mesa, Manila',
            'date_of_birth' => '1990-01-01',
        ]);
    }
}