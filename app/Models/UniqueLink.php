<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UniqueLink extends Model
{
    protected $fillable = [
        'player_id',
        'unique_link',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
