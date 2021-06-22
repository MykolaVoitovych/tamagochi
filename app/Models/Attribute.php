<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    const FOOD = 'food';
    const SLEEP = 'sleep';
    const CARE = 'care';

    protected $fillable = [
        'name',
        'increase_interval',
        'decrease_interval',
        'max_value',
        'min_value',
        'critical_value',
        'critical_interval'
    ];

    protected $appends = [
        'value',
        'dt_increased'
    ];

    public $timestamps = false;

    public function pets()
    {
        return $this->belongsToMany(Pet::class)
            ->using(AttributePet::class);
    }

    public function getValueAttribute()
    {
        return optional($this->pivot)->value;
    }

    public function getDtIncreasedAttribute()
    {
        return optional($this->pivot)->dt_increased;
    }

    public function getCriticalIntervalAttribute()
    {
        $originalValue = $this->getRawOriginal('critical_interval');
        if (!$originalValue) {
            return $this->decrease_interval / 3;
        }
        return $originalValue;
    }
}
