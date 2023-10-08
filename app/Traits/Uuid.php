<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    public static function bootUuid(): void
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = $model->{$model->getKeyName()} ?: (string)Str::orderedUuid();
        });
    }
}
