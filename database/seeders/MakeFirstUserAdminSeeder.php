<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeFirstUserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remplacez 'votre@email.com' par l'email de votre compte !
        User::where('email', 'mrdarkhorse@email.com')->update(['is_admin' => true]);
    }
}