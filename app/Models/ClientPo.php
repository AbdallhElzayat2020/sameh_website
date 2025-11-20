<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ClientPo extends Model
{
    protected $fillable = [
        'task_code',
        'client_code',
        'date_20',
        'date_80',
        'payment_20',
        'payment_80',
        'total_price',
        'status',
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'client_po_service');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_code', 'client_code');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_code', 'task_number');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(ClientInvoice::class);
    }

    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable');
    }

    protected function casts(): array
    {
        return [
            'date_20' => 'date',
            'date_80' => 'date',
            'payment_20' => 'decimal:2',
            'payment_80' => 'decimal:2',
            'total_price' => 'decimal:2',
        ];
    }
}
