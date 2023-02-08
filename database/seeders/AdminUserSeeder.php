<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exists = User::where('email', 'admin@mail.com')->count();
        if (!$exists)
            User::insert([
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('password'),
            ]);
    }
}
