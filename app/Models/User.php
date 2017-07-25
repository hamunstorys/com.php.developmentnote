<?php

namespace App\Models;

use App\Models\Article\Article;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirm_code', 'activated'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'confirm_code'
    ];

    protected $casts = ['activated' => 'boolean',];

    public function Authorities()
    {
        return $this->hasMany(Authority::class);
    }

    public function isAdmin()
    {

    }
}
