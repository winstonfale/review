<?php

use App\Enums\WebsiteIds;
use App\Models\Review;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DummyReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();

        $ratings = [1, 2, 3, 4, 5];

        $comment = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

        for ($i = 1; $i <= 50; $i++) {

            $website_id = $faker->randomElement(WebsiteIds::getValues());
            
            Review::create([
                'website_id' => $website_id,
                'commentor_id' => 1,
                'website_url' => WebsiteIds::getKey($website_id),
                'name' => $faker->name,
                'rating' => $faker->randomElement($ratings),
                'comment' => $comment,
                'feedback' =>  $faker->randomElement(['Wow', 'Aweseome', 'Nice', '']),
            ]);
        }


    }
}
