<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ProjectRequest extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'project_name',
        'description',
        'time_zone',
        'start_date',
        'start_date_time',
        'end_date',
        'end_date_time',
        'preferred_payment_type',
        'source_language',
        'target_language',
        'status',
        'currency',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'request_service');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }
}
