<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['name' => 'Мастер на все руки', 'slug' => 'master-na-vse-ruki', 'sort_order' => 1],
            ['name' => 'Выезд мастера на час', 'slug' => 'vyezd-mastera-na-chas', 'sort_order' => 2],
            ['name' => 'Сборка мебели', 'slug' => 'sborka-mebeli', 'sort_order' => 3],
            ['name' => 'Сантехнические работы', 'slug' => 'santehnicheskie-raboty', 'sort_order' => 4],
            ['name' => 'Рабочий на час', 'slug' => 'rabochij-na-chas', 'sort_order' => 5],
            ['name' => 'Электромонтажные работы', 'slug' => 'elektromontazhnye-raboty', 'sort_order' => 6],
            ['name' => 'Укладка плитки', 'slug' => 'ukladka-plitki', 'sort_order' => 7],
            ['name' => 'Ремонт и строительство', 'slug' => 'remont-i-stroitelstvo', 'sort_order' => 8],
        ];
        foreach ($items as $item) {
            Category::firstOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
