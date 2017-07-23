<?php

namespace App\Models\Article;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table = 'articles';

    protected $fillable = [
        'subject',
        'content',
        'name',
    ];

    protected $dates = [
        'deleted_at'
    ];

    /* Eloquent Relation */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::
        class);
    }
}