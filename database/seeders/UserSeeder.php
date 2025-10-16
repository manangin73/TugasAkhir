<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        $user = [
            [
                'id_user' => 1,
                'username' => "ADMIN",
                'email' => 'admin@gmail.com',
                'no_wa' => '0811',
                'password' => bcrypt('111111'),
                'user_role' => "admin" //atasan
            ],
            [
                'id_user' => 2,
                'username' => "sarpras",
                'email' => 'sarpras@gmail.com',
                'no_wa' => '0822',
                'password' => bcrypt('111111'),
                'user_role' => "k3l" //atasan
            ],
            [
                'id_user' => 3,
                'username' => "User",
                'email' => 'user@gmail.com',
                'no_wa' => '0833',
                'password' => bcrypt('111111'),
                'user_role' => "user" //atasan
            ],
            [
                'id_user' => 4,
                'username' => "ukmbs",
                'email' => 'ukmbs@gmail.com',
                'no_wa' => '0833',
                'password' => bcrypt('111111'),
                'user_role' => "ukmbs" //atasan
            ],
        ];

        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
