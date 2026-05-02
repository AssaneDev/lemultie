<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Meditation;
use App\Models\Formation;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@multivoix.fr'],
            [
                'name' => 'Admin Multi-Voix',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $services = [
            ['title' => 'Discours de mariage', 'category' => 'copywriting', 'price' => 150],
            ['title' => 'Voix off corporate', 'category' => 'voix_off', 'price' => 200],
            ['title' => 'Atelier percussions', 'category' => 'percussion', 'price' => 80],
            ['title' => 'Conte sur mesure', 'category' => 'conte', 'price' => 120],
        ];

        foreach ($services as $data) {
            Service::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, [
                    'description' => 'Description du service ' . $data['title'],
                    'is_active' => true,
                    'is_premium' => false,
                    'order' => 0,
                ])
            );
        }

        $meditations = [
            ['title' => 'Méditation du matin', 'theme' => 'energie', 'type' => 'audio', 'duration_seconds' => 600],
            ['title' => 'Relaxation profonde', 'theme' => 'relaxation', 'type' => 'audio', 'duration_seconds' => 900],
            ['title' => 'Sommeil réparateur', 'theme' => 'sommeil', 'type' => 'audio', 'duration_seconds' => 1800],
        ];

        foreach ($meditations as $data) {
            Meditation::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                array_merge($data, [
                    'description' => 'Une guidance pour ' . $data['title'],
                    'is_active' => true,
                    'is_premium' => false,
                ])
            );
        }

        Formation::firstOrCreate(
            ['slug' => 'oralite-et-expression'],
            [
                'title' => 'Oralité & Expression',
                'description' => 'Apprenez à maîtriser votre voix et votre présence orale.',
                'price' => 297,
                'level' => 'debutant',
                'duration_hours' => 8,
                'is_active' => true,
                'is_premium' => false,
            ]
        );

        Article::firstOrCreate(
            ['slug' => 'le-pouvoir-de-la-voix'],
            [
                'user_id' => $admin->id,
                'title' => 'Le pouvoir de la voix',
                'excerpt' => 'Découvrez comment la voix peut transformer vos relations et votre impact.',
                'content' => '<p>La voix est un outil extraordinaire...</p>',
                'type' => 'article',
                'is_published' => true,
                'is_premium' => false,
                'published_at' => now(),
            ]
        );
    }
}
