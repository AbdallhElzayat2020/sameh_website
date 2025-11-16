<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FreelancerInvoice extends Model
{
    protected $fillable = [
        'freelancer_po_id',
        'status',
    ];

    public function freelancerPo(): BelongsTo
    {
        return $this->belongsTo(FreelancerPo::class, 'freelancer_po_id');
    }
}
