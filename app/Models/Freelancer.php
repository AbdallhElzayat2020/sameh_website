<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Freelancer extends Model
{
    protected $fillable = [
        'freelancer_code',
        'name',
        'email',
        'phone',
        'language_pair',
        'quota',
        'price_hr',
        'currency',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'freelancer_service');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    protected function casts(): array
    {
        return [
            'language_pair' => 'array',
        ];
    }
}
