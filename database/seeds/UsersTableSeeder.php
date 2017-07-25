<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::create([
            'level' => 0,
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('000000'),
            'activated' => 1
        ]);
    }
}
