<?php

use App\Page;
use Faker\Generator as Faker;



$factory->define(Page::class, function (Faker $faker) {
    return [
        'content'=> $faker -> text,
        'title' => $faker ->text(100),
        'category_id' => rand(1,10),
        'author_id' => 0,
        'published' => rand(0,1),
    ];
});
