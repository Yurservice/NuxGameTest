<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Game extends Model
{
    protected $fillable = [
        'player_id',
        'random_figure',
        'reward',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function calculateWinAmount(int $figure): float
    {
        $percentage = match (true) {
            $figure > 900 => 0.7,
            $figure > 600 => 0.5,
            $figure > 300 => 0.3,
            default => 0.1,
        };
        
        return round($figure * $percentage, 2);
    }
}
