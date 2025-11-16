<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientInvoice extends Model
{
    protected $fillable = [
        'client_po_id',
        'status',
    ];

    public function clientPo(): BelongsTo
    {
        return $this->belongsTo(ClientPo::class, 'client_po_id');
    }
}
