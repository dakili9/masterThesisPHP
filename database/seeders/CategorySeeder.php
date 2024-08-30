<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'id' => '8d3fd19b-07f0-4cae-9399-b404f45b3f56',
            'name' => 'Work',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'id' => '062fedb0-b82e-4c6c-af1d-cf290a3b0d6a',
            'name' => 'Personal',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Category::create([
            'id' => '05164132-1320-4a6e-8184-2722acac7e0f',
            'name' => 'Urgent',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
