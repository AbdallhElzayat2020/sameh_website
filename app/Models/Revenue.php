<?php

namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Revenue extends Model {
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
