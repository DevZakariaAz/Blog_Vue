<?php

namespace Modules\Article\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'Article 1',
            ],
            [
                'title' => 'Article 2',
            ],
            [
                'title' => 'Article 3',
            ],
        ];

        foreach ($articles as $article) {
            \Modules\Article\Models\Article::create($article);
        }
    }
}
