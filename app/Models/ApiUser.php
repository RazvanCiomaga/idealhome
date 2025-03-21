<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class ApiUser extends Authenticatable
{
    use HasApiTokens;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->client_id = Str::uuid();
            $model->client_secret = Str::random(40);
        });
    }
}
