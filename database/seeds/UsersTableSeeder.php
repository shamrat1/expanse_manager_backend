<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Admin',
                'email'          => 'admin@admin.com',
                'password'       => Hash::make(123456),
                'remember_token' => null,
                'created_at'     => '2019-09-13 19:21:30',
                'updated_at'     => '2019-09-13 19:21:30',
            ],
        ];

        User::insert($users);
    }
}
