<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Task extends Model
{
    protected $fillable = [
        'task_number',
        'reference_number',
        'page_numbers',
        'words_count',
        'client_code',
        'language_pair',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'notes',
        'created_by',
        'closed_by',
        'status',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function closer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'closed_by');
    }

    public function referencedTask(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'reference_number');
    }

    public function referencingTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'reference_number');
    }

    public function taskServices(): HasMany
    {
        return $this->hasMany(TaskService::class);
    }

    public function taskLanguages(): HasMany
    {
        return $this->hasMany(TaskLanguage::class);
    }

    public function freelancerTasks(): HasMany
    {
        return $this->hasMany(FreelancerTask::class);
    }

    public function freelancers(): BelongsToMany
    {
        return $this->belongsToMany(
            Freelancer::class,
            'freelancer_task',
            'task_id',
            'freelancer_code',
            'id',
            'freelancer_code'
        );
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'task_service');
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
            'language_pair' => 'array',
        ];
    }
}
