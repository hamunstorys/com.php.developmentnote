<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Select extends Model
{
    protected $table = 'select';

    protected $fillable = [
        'query',
    ];
}