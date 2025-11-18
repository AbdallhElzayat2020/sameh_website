<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCapital extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_capital_egp',
        'total_capital_usd',
        'temporary_capital_egp',
        'temporary_capital_usd',
        'emergency_capital_egp',
        'emergency_capital_usd',
    ];
}
