<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table = 'searches';

    protected $fillable = [
        'selected',
        'query',
        'count',
    ];
}
