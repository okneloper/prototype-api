<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createUsers();
    }

    /**
     * Creates users and some default (hardcoded) tokens to use in testing
     */
    private function createUsers(): void
    {
        $user = User::create([
            'id' => 1,
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => '',
        ]);
        /* @var $user User */
        $user->createToken('default', ['*'])->accessToken->update([
            // 1|RyBbpYpNUqCUFz3QaDgMaY5SaKj5bbnz1s5HI43B
            'token' => '2011363e6b4e68844e5ef7ce144ffa2f763be78f4cf9d8bcbb27d8be19a1ce52',
        ]);

        $user = User::create([
            'id' => 2,
            'name' => 'Sales department',
            'email' => 'sales@example.com',
            'password' => '',
        ]);
        $user->createToken('default', ['*'])->accessToken->update([
            // 2|mVIWH2VgQlWJpt7JfFHTUCkxwZVBFtBcLj75tNJT
            'token' => '1afa2acdec9b2972c6faabc918637e7e7b80e2d2db406cbb38b48f9c57c8684f',
        ]);

        $user = User::create([
            'id' => 3,
            'name' => 'Courier',
            'email' => 'courier@example.com',
            'password' => '',
        ]);
        $user->createToken('default', ['*'])->accessToken->update([
            // 3|gkw9V7bbQ6OgeFokLELSdhGBHG9eBVDLInnUwNoN
            'token' => 'e5f88194f6da2a4ec400be43f989692d46aee09d5b4d92211d0d6c5d2c3bd4b6',
        ]);
    }
}
