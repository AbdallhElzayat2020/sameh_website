<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'mediaable_id',
        'mediaable_type',
        'type',
    ];

    public function mediaable(): MorphTo
    {
        return $this->morphTo();
    }
}
