<?php

namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Freelancer extends Model {
        protected $fillable = [
        'freelancer_code',
        'name',
        'email',
        'phone',
        'language_pair',
        'quota',
        'price_hr',
        'currency',
        ];

        protected function casts(): array
        {
        return [
        'language_pair' => 'array',
        ];
        }
    }
