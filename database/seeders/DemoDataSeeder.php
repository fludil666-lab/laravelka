<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SpecialistProfile;
use App\Models\SpecialistService;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::all()->keyBy('slug');

        $specialists = [
            [
                'name' => 'Андрей Иванов',
                'email' => 'electrician@example.com',
                'city' => 'Москва',
                'description' => 'Электромонтажные работы любой сложности. Замена проводки, установка розеток и выключателей, подключение люстр, сборка щитков. Опыт 12 лет. Работаю по договору, даю гарантию.',
                'with_guarantee' => true,
                'works_by_contract' => true,
                'passport_verified' => true,
                'services' => [
                    ['category' => 'elektromontazhnye-raboty', 'title' => 'Замена проводки', 'price_from' => 5000, 'price_type' => 'fixed'],
                    ['category' => 'elektromontazhnye-raboty', 'title' => 'Установка розетки/выключателя', 'price_from' => 500, 'price_type' => 'fixed'],
                    ['category' => 'elektromontazhnye-raboty', 'title' => 'Подключение люстры', 'price_from' => 1500, 'price_type' => 'fixed'],
                ],
            ],
            [
                'name' => 'Михаил Петров',
                'email' => 'tiler@example.com',
                'city' => 'Москва',
                'description' => 'Укладка плитки в ванной, кухне, прихожей. Выравнивание стен, затирка. Качественные материалы. Гарантия на работы.',
                'with_guarantee' => true,
                'works_by_contract' => true,
                'passport_verified' => true,
                'services' => [
                    ['category' => 'ukladka-plitki', 'title' => 'Укладка плитки на пол', 'price_from' => 1200, 'price_type' => 'fixed'],
                    ['category' => 'ukladka-plitki', 'title' => 'Укладка плитки на стену', 'price_from' => 1500, 'price_type' => 'fixed'],
                    ['category' => 'ukladka-plitki', 'title' => 'Затирка швов', 'price_from' => 400, 'price_type' => 'fixed'],
                ],
            ],
            [
                'name' => 'Сергей Козлов',
                'email' => 'builder@example.com',
                'city' => 'Москва',
                'description' => 'Ремонт и строительство под ключ. Штукатурка, стяжка, гипсокартон, покраска. Мастер на все руки с опытом 15 лет. Выезд в день обращения.',
                'with_guarantee' => true,
                'works_by_contract' => true,
                'passport_verified' => false,
                'services' => [
                    ['category' => 'remont-i-stroitelstvo', 'title' => 'Штукатурка стен', 'price_from' => 450, 'price_type' => 'fixed'],
                    ['category' => 'remont-i-stroitelstvo', 'title' => 'Стяжка пола', 'price_from' => 350, 'price_type' => 'fixed'],
                    ['category' => 'rabochij-na-chas', 'title' => 'Мастер на час', 'price_from' => 800, 'price_type' => 'fixed'],
                ],
            ],
            [
                'name' => 'Дмитрий Смирнов',
                'email' => 'plumber@example.com',
                'city' => 'Москва',
                'description' => 'Сантехнические работы: устранение засоров, замена труб, установка сантехники, обслуживание септиков. Работаю по договору.',
                'with_guarantee' => true,
                'works_by_contract' => true,
                'passport_verified' => true,
                'services' => [
                    ['category' => 'santehnicheskie-raboty', 'title' => 'Устранение засора канализации', 'price_from' => 2500, 'price_type' => 'fixed'],
                    ['category' => 'santehnicheskie-raboty', 'title' => 'Замена смесителя', 'price_from' => 1500, 'price_type' => 'fixed'],
                    ['category' => 'santehnicheskie-raboty', 'title' => 'Установка унитаза', 'price_from' => 3500, 'price_type' => 'by_agreement'],
                ],
            ],
        ];

        foreach ($specialists as $data) {
            $servicesData = $data['services'];
            unset($data['services']);

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'specialist',
                ]
            );

            $profile = SpecialistProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'city' => $data['city'],
                    'description' => $data['description'],
                    'with_guarantee' => $data['with_guarantee'],
                    'works_by_contract' => $data['works_by_contract'],
                    'passport_verified' => $data['passport_verified'],
                    'last_online_at' => now(),
                ]
            );

            foreach ($servicesData as $srv) {
                $cat = $categories->get($srv['category']);
                if (!$cat) continue;
                SpecialistService::firstOrCreate(
                    [
                        'specialist_profile_id' => $profile->id,
                        'category_id' => $cat->id,
                        'title' => $srv['title'],
                    ],
                    [
                        'price_from' => $srv['price_from'] ?? null,
                        'price_type' => $srv['price_type'] ?? 'by_agreement',
                    ]
                );
            }
        }
    }
}
