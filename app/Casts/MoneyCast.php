<?php

namespace App\Casts;



use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Str;

class MoneyCast implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes): float
    {
        return round(floatval($value) / 100, 2);
    }

    public function set($model, string $key, $value, array $attributes): float
    {
        $value = Str::replace('.', '', $value);
        $value = Str::replace(' ', '', $value);
        $value = Str::replace(',', '.', $value);

        // Transform the float into an integer for storage.
        return round(floatval($value) * 100);
    }
}
