<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'sandeep198558@yahoo.com'],
            [
                'name' => 'Sandeep Rathod',
                'mobile' => '9664588677',
                'password' => Hash::make('password'),
            ]
        );

        $user->syncRoles(['Admin', 'Organization', 'Driver', 'Attendant', 'Parent']);

        // Seed some children for the parent Sandeep
        \App\Models\Child::firstOrCreate(
            ['parent_id' => $user->id, 'name' => 'Aarav Rathod'],
            ['gender' => 'Male', 'dob' => '2016-05-15']
        );
        \App\Models\Child::firstOrCreate(
            ['parent_id' => $user->id, 'name' => 'Kiara Rathod'],
            ['gender' => 'Female', 'dob' => '2019-10-20']
        );

        // Seed Leena Adam
        $leena = User::firstOrCreate(
            ['email' => 'leenaadam28@gmail.com'],
            [
                'name' => 'Leena Adam',
                'mobile' => '9769409405',
                'password' => Hash::make('password'),
            ]
        );

        $leena->syncRoles(['Parent', 'Organization']);
    }
}
