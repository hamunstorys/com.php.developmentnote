<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::create([
            'name' => '홍진섭',
            'email' => 'hamunstorys@gmail.com',
            'password' => bcrypt('0000'),
        ]);
    }
}
