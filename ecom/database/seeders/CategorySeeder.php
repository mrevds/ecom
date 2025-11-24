<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categories;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            'Electronics',
            'Clothing',
            'Books',
            'Sports',
            'Home & Garden',
        ];

        foreach ($categories as $name) {
            Categories::create([
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name),
            ]);
        }
    }
}
