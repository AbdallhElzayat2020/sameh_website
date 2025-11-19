<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Freelancer extends Model
{
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

    public static function nextFreelancerCode(): string
    {
        $lastest_code = self::orderByDesc('id')->value('freelancer_code');

        $code = Str::afterLast($lastest_code ?? 0, 'F_');

        $new_code = Str::padLeft(++$code, 5, '0');

        return "F_$new_code";
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'freelancer_service');
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    protected function casts(): array
    {
        return [
            'language_pair' => 'array',
        ];
    }
}
