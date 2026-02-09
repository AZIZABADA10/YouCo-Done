<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un admin
        $admin = User::create([
            'name' => 'Admin YouCoDone',
            'email' => 'admin@youcodone.com',
            'password' => Hash::make('password'),
            'phone' => '+212600000000',
            'is_active' => true,
        ]);
        $admin->assignRole('admin');

        // Créer un restaurateur
        $restaurateur = User::create([
            'name' => 'Restaurateur Test',
            'email' => 'restaurateur@youcodone.com',
            'password' => Hash::make('password'),
            'phone' => '+212600000001',
            'is_active' => true,
        ]);
        $restaurateur->assignRole('restaurateur');

        // Créer un client
        $client = User::create([
            'name' => 'Client Test',
            'email' => 'client@youcodone.com',
            'password' => Hash::make('password'),
            'phone' => '+212600000002',
            'is_active' => true,
        ]);
        $client->assignRole('client');
    }
}