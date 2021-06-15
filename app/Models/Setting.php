<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'increase_interval',
        'decrease_interval',
        'max_value',
        'min_value',
        'critical_value',
        'critical_interval'
    ];

    public $timestamps = false;

    public function getCriticalIntervalAttribute()
    {
        $originalValue = $this->getRawOriginal('critical_interval');
        if (!$originalValue) {
            return $this->decrease_interval / 3;
        }
        return $originalValue;
    }
}
