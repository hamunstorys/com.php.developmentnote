<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authority extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'administrator',
        'articles_creatable', 'articles_updatable', 'articles_deletable',
        'comments_creatable', 'comments_updatable', 'comments_deletable'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected $casts = ['administrator' => 'boolean',
        'articles_creatable' => 'boolean', 'articles_updatable' => 'boolean', 'articles_deletable' => 'boolean',
        'comments_creatable' => 'boolean', 'comments_updatable' => 'boolean', 'comments_deletable' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
