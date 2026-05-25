<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure the test user exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User']
        );

        // Ensure categories exist (CategorySeeder covers this, but be safe)
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        $categories = Category::pluck('id', 'slug')->all();

        $samples = [
            [
                'title' => 'Lawn Mower — Borrow for Weekend',
                'category_slug' => 'tools-equipment',
                'description' => 'Lightweight lawn mower available for short-term borrow. Pickup in downtown area. Fuel not included.',
                'type' => 'share',
                'status' => 'active',
                'location' => 'Downtown',
            ],
            [
                'title' => 'Frontend Mentor — 1:1 Help',
                'category_slug' => 'skills-expertise',
                'description' => 'Offering 1-hour frontend mentoring sessions to help debug CSS and accessibility issues.',
                'type' => 'share',
                'status' => 'active',
                'location' => 'Remote',
            ],
            [
                'title' => 'React Project Review',
                'category_slug' => 'digital-resources',
                'description' => 'Looking for a quick review of a small React codebase. 30-60 minute session.',
                'type' => 'request',
                'status' => 'active',
                'location' => 'Remote',
            ],
        ];

        foreach ($samples as $sample) {
            $catId = $categories[$sample['category_slug']] ?? Category::first()->id;

            $slug = Str::slug($sample['title']) . '-' . Str::random(6);

            Resource::updateOrCreate([
                'title' => $sample['title'],
                'user_id' => $user->id,
            ], [
                'slug' => $slug,
                'category_id' => $catId,
                'description' => $sample['description'],
                'type' => $sample['type'],
                'status' => $sample['status'],
                'location' => $sample['location'],
                'contact_email' => $user->email,
            ]);
        }
    }
}
