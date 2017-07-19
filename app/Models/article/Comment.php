<?php

namespace App\Models\article;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $fillable = [
        'name',
        'comment',
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class)->withPivot('id');
    }
}
