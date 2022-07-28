<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => "Admin Sistem",
                'email' => 'admin@admin.com',
                'password' => Hash::make('10203040'),
            ],
        ];
        foreach ($users as $user) {
            $user = User::create($user);
            $role = config('roles.models.role')::where('name', '=', "Admin")->first();
            $user->attachRole($role);
        }
    }
}
