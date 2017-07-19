<?php

use Illuminate\Database\Seeder;

class ArticleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\article\Article::create([
            'subject' => '테스트',
            'content' => '테스트',
            'name' => '테스트',
        ]);
    }
}
