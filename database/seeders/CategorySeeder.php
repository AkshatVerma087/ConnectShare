<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the categories table.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Tools & Equipment',
                'slug'        => 'tools-equipment',
                'icon'        => 'bi-tools',
                'description' => 'Physical tools, hardware, and equipment',
            ],
            [
                'name'        => 'Skills & Expertise',
                'slug'        => 'skills-expertise',
                'icon'        => 'bi-person-gear',
                'description' => 'Professional skills and personal expertise',
            ],
            [
                'name'        => 'Knowledge & Courses',
                'slug'        => 'knowledge-courses',
                'icon'        => 'bi-book',
                'description' => 'Educational material, guides, and courses',
            ],
            [
                'name'        => 'Services',
                'slug'        => 'services',
                'icon'        => 'bi-briefcase',
                'description' => 'Professional or personal services',
            ],
            [
                'name'        => 'Digital Resources',
                'slug'        => 'digital-resources',
                'icon'        => 'bi-laptop',
                'description' => 'Software, templates, and digital assets',
            ],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
