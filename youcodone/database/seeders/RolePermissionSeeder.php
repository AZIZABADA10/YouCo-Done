<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Réinitialiser les rôles et permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions
        $permissions = [
            // Permissions Restaurant
            'view-restaurants',
            'create-restaurant',
            'edit-restaurant',
            'delete-restaurant',
            'manage-own-restaurant',
            
            // Permissions Menu
            'view-menus',
            'create-menu',
            'edit-menu',
            'delete-menu',
            
            // Permissions Plat
            'view-plats',
            'create-plat',
            'edit-plat',
            'delete-plat',
            
            // Permissions Favoris
            'add-favorite',
            'remove-favorite',
            'view-favorites',
            
            // Permissions Admin
            'view-dashboard',
            'manage-users',
            'manage-all-restaurants',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Créer les rôles et assigner les permissions

        // Rôle Admin
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Rôle Restaurateur
        $restaurateurRole = Role::create(['name' => 'restaurateur']);
        $restaurateurRole->givePermissionTo([
            'view-restaurants',
            'create-restaurant',
            'edit-restaurant',
            'delete-restaurant',
            'manage-own-restaurant',
            'view-menus',
            'create-menu',
            'edit-menu',
            'delete-menu',
            'view-plats',
            'create-plat',
            'edit-plat',
            'delete-plat',
        ]);


        $clientRole = Role::create(['name' => 'client']);
        $clientRole->givePermissionTo([
            'view-restaurants',
            'view-menus',
            'view-plats',
            'add-favorite',
            'remove-favorite',
            'view-favorites',
        ]);
    }
}