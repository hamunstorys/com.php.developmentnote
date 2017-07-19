<?php

namespace App\Models\article;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table = 'searches';

    protected $fillable = [
        'selected',
        'query',
        'articles',
        'count',
    ];

    protected $casts = [
        'features' => 'json'
    ];

}
