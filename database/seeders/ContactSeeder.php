<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contact::factory()
            ->count(20)
            ->create()
            ->each(function ($contact) {
                $allTags = \App\Models\Tag::all();
                echo "All Tags Count: " . $allTags->count() . "\n";

                $randomTags = $allTags->random(fake()->numberBetween(1, 3));

                echo "Random Tags: " . $randomTags->pluck('id')->implode(',') . "\n";

                foreach ($randomTags as $tag) {
                    $contact->tags()->attach($tag->id, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });
    }
}
