<?php

use App\Models\Authority;
use App\Models\User;
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
        $this->CreateAdministrator();
    }

    public function CreateAdministrator()
    {
        $user = new User;
        $user->fill([
            'name' => 'administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('000000'),
            'activated' => 1
        ]);
        $user->save();

        $authority = new Authority;
        $authority->fill(['administrator' => 1,
            'articles_creatable' => 1, 'articles_updatable' => 1, 'articles_deletable' => 1,
            'comments_creatable' => 1, 'comments_updatable' => 1, 'comments_deletable' => 1
        ]);
        $user->Authorities()->save($authority);
        $authority->save();
    }
}
