<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        DB::table('articles')->insert([
            [
                'title' => 'First Article',
                'content' => 'This is the content of the first article.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Second Article',
                'content' => 'This is the content of the second article.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
