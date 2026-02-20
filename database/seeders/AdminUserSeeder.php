<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'prenom' => 'Super',
            'email' => 'admin@bakeli.sn',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Member',
            'prenom' => 'Super',
            'email' => 'member@bakeli.sn',
            'role' => 'member',
            'password' => Hash::make('password'),
        ]);
    }
}
