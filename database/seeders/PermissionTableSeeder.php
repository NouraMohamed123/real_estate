<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [

            // "users-list",
            // "update-user",
            // "delete-user",
            // "add-user",
            // "role",
            // "roles-list",
            // "update-role",
            // "delete-role",
            // "add-role",
            // "setting",
            // "update-or-create-setting",
            "apartment",
            "apartment-list",
            "update-apartment",
            "delete-apartment",
            "add-apartment",
            "expense",
            "expense-list",
            "update-expense",
            "delete-expense",
            "add-expense",
            "rent",
            "rent-list",
            "update-rent",
            "delete-rent",
            "add-rent",
            "dashboard",
            "category",
            "category-list",
            "update-category",
            "delete-category",
            "add-category",







        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }

}
