<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $roles = ['super_admin', 'group_admin', 'mentor', 'student', 'parent'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Create users
        $adminUser = User::factory()->withPersonalTeam()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $testUser = User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $ibrahimUser = User::factory()->withPersonalTeam()->create([
            'name' => 'Mohamed Ibrahim',
            'email' => 'ibrahim.softsuave@gmail.com',
        ]);

        // Assign roles to users
        $adminUser->assignRole('super_admin');
        $testUser->assignRole('group_admin');
        $ibrahimUser->assignRole('mentor');
    }
}