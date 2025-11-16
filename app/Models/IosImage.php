<?php

namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class IosImage extends Model {
        protected $fillable = [
        'img_path',
        'title',
        ];
    }
