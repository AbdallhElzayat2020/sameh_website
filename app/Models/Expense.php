<?php

namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Expense extends Model {
        protected $fillable = [
        'total',
        'month',
        ];

        protected function casts(): array
        {
        return [
        'month' => 'date',
        ];
        }
    }
