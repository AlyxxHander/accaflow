<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $roles = \App\Models\Role::all()->pluck('id', 'name');

        \App\Models\User::create([
            'name' => 'Staff Admin',
            'email' => 'admin@accaflow.com',
            'password' => bcrypt('password'),
            'role_id' => $roles['admin'],
        ]);

        \App\Models\User::create([
            'name' => 'Mahasiswa Demo',
            'email' => 'student@accaflow.com',
            'password' => bcrypt('password'),
            'role_id' => $roles['student'],
        ]);

        \App\Models\User::create([
            'name' => 'Kaprodi Informatika',
            'email' => 'kaprodi@accaflow.com',
            'password' => bcrypt('password'),
            'role_id' => $roles['kaprodi'],
        ]);

        \App\Models\User::create([
            'name' => 'Dosen Senior',
            'email' => 'dosen@accaflow.com',
            'password' => bcrypt('password'),
            'role_id' => $roles['dosen'],
        ]);

        \App\Models\User::create([
            'name' => 'Super Admin Dev',
            'email' => 'superadmin@accaflow.com',
            'password' => bcrypt('password'),
            'role_id' => $roles['super_admin'],
        ]);
    }
}
