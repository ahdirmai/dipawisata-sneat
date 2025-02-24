<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // create category
        $data_category = [
            [
                'name' => 'kategori 1',
                'slug' => 'kategori-1',
            ],
            [
                'name' => 'kategori 2',
                'slug' => 'kategori-2',
            ],
            [
                'name' => 'kategori 3',
                'slug' => 'kategori-3',
            ],
        ];

        foreach ($data_category as $category) {
            \App\Models\Blog\Category::create($category);
        }
    }
}
