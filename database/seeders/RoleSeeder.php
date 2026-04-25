<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'Administrator'],
            ['name' => 'student', 'display_name' => 'Mahasiswa'],
            ['name' => 'kaprodi', 'display_name' => 'Ketua Program Studi'],
            ['name' => 'dosen', 'display_name' => 'Dosen'],
            ['name' => 'super_admin', 'display_name' => 'Super Administrator (Developer)'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
