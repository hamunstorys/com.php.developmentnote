<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];

    /* Eloquent Relation */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
