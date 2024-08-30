<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() === 0 || Category::count() === 0) {
            $this->command->warn('No users or categories found, seeding default users and categories first.');
            $this->call([
                UserSeeder::class,
                CategorySeeder::class,
            ]);
        }

        Task::factory()->count(30)->create();

        Task::factory()->count(10)->pending()->create();
    }
}
