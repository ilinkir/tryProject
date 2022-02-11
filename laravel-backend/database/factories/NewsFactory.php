<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\News;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = implode(' ', $this->faker->unique()->words(2));
        $categoryIds = Category::select('id')->get();
        $imageIds = News::query()->select('id')->get();

        $imageRandom = $imageIds->isEmpty() ? null : $imageIds->random();

        return [
            'title' => Str::title($name),
            'code' => Str::snake($name),
            'preview_text' => $this->faker->text(100),
            'category_id' => $categoryIds->random(),
            'image_id' => $imageRandom,
            'text' => $this->getFakeData($this->faker),
        ];
    }

    /**
     * Gets a random set of paragraphs
     *
     * @param Faker\Generator
     * @return string
     */
    public function getFakeData(Generator $faker)
    {
        $paragraphs = random_int(3, 5);
        $i = 0;
        $ret = "";
        $ret .= "<h1>" . $faker->sentence() . "</h1>";
        while ($i < $paragraphs) {
            $ret .= "<p>" . $faker->paragraph(random_int(3, 5)) . "</p>";
            $i++;
        }
        return $ret;
    }
}
