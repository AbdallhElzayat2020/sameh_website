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
        'path',
        'original_name',
        'mime_type',
        'size',
        'note',
        'file_status',
    ];

    public function mediaable(): MorphTo
    {
        return $this->morphTo();
    }
}
