<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('Admin.123'),
                'roles' => 'admin',
                'status' => 'active',
                'remember_token' => Str::random(64),
            ],
        ];

        foreach ($users as $us) {
            User::create($us);
        }
    }
}
