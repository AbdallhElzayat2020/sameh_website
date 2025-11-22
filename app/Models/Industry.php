<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Industry extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
}
