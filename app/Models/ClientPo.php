<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function invoice(): HasOne
    {
        return $this->hasOne(ClientInvoice::class);
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
