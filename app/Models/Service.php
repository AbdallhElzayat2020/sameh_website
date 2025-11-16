<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    protected $fillable = [
        'name',
        'desc',
        'status',
    ];

    public function projectRequests(): BelongsToMany
    {
        return $this->belongsToMany(ProjectRequest::class, 'request_service');
    }

    public function freelancerPoServices(): BelongsToMany
    {
        return $this->belongsToMany(FreelancerPo::class, 'freelancer_po_service');
    }

    public function clientPoServices(): BelongsToMany
    {
        return $this->belongsToMany(ClientPo::class, 'client_po_service');
    }

    protected function casts(): array
    {
        return [
            'desc' => 'array',
        ];
    }
}
