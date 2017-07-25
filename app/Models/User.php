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
    protected $fillable = ['level',
        'name', 'email', 'password', 'confirm_code', 'activated',];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'confirm_code'
    ];

    protected $casts = ['activated' => 'boolean',];

    public function authorities()
    {
        return $this->hasMany(Authority::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Article::class);
    }

    /* level 0 */
    public function isAdmin()
    {
        return ($this->level === 0) ? true : false;
    }

    public function isGeneral()
    {
        return ($this->level === 1) ? true : false;
    }
}
