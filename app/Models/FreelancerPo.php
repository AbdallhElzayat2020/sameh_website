<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FreelancerPo extends Model
{
    protected $fillable = [
        'freelancer_code',
        'task_code',
        'project_name',
        'page_number',
        'price',
        'start_date',
        'payment_date',
        'note',
        'created_by',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'payment_date' => 'date',
            'price' => 'decimal:2',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'freelancer_po_service');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(FreelancerInvoice::class);
    }
}
