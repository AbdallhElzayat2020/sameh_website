<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'language_pair' => 'array',
        ];
    }
}
