<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Industry extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function industryOptions(): HasMany
    {
        return $this->hasMany(IndustryOption::class, 'industry_id');
    }

    // Todo morph image and icon
}
