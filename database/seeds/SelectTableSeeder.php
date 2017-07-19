<?php

use Illuminate\Database\Seeder;

class SelectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create('subject', 0);
    }

    public function create($query, $value)
    {
        App\Models\article\Select::create([
            'query' => $query,
            'value' => $value
        ]);
    }
}
