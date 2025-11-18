<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Revenue extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'month',
    ];

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function sheet(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable')
            ->where('type', 'revenue_sheet')
            ->latestOfMany();
    }

    protected function casts(): array
    {
        return [
            'month' => 'date',
        ];
    }
}
