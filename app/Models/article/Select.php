<?php

namespace App\Models\article;

use Illuminate\Database\Eloquent\Model;

class Select extends Model
{
    protected $table = 'select';

    protected $fillable = [
        'query',
    ];
}
