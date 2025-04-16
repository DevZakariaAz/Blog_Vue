<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionGroups = [
            'article' => ['create', 'edit', 'delete', 'view'],
            'tag' => ['create', 'edit', 'delete', 'view'],
            'category' => ['create', 'edit', 'delete', 'view'],
            'comment' => ['create', 'edit', 'delete', 'view'],
            'user' => ['manage'],
            'settings' => ['edit'],
        ];

        foreach ($permissionGroups as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action} {$module}"]);
            }
        }

        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);
        $userRole = Role::create(['name' => 'user']);

        $adminRole->givePermissionTo(Permission::all());
        $editorRole->givePermissionTo([
            'create article',
            'edit article',
            'view article',
            'delete article',
            'create comment',
            'edit comment',
            'view comment',
            'delete comment',
            'view category',
            'view tag'
        ]);
        $userRole->givePermissionTo(['view article', 'view comment']);

        // Create a user and assign the admin role
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password'
        ]);
        $user->assignRole('admin');

        // Create a user and assign the editor role
        $editor = User::create([
            'name' => 'Editor',
            'email' => 'editor@gmail.com',
            'password' => 'password'
        ]);
        $editor->assignRole('editor');
    }
}
