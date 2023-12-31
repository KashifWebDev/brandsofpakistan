<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            AssignPermissionsToRoles::class,
        ]);

        User::factory(1)->create();
        BlogCategory::factory()->count(10)->create();
        Blog::factory()->count(10)->create();
    }
}
