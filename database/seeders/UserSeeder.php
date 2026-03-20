<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'              => 'Administrateur',
                'email'             => 'admin@example.com',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name'              => 'Jean Dupont',
                'email'             => 'jean.dupont@example.com',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],
            [
                'name'              => 'Marie Martin',
                'email'             => 'marie.martin@example.com',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        $this->command->info('✓ ' . count($users) . ' utilisateurs créés.');
    }
}