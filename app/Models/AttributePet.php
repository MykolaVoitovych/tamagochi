<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AttributePet extends Pivot
{
    protected $fillable = [
        'pet_id',
        'attribute_id',
        'value',
        'dt_increased',
        'dt_decreased'
    ];

    protected $casts = [
        'value' => 'integer',
        'dt_increased' => 'datetime',
        'dt_decreased' => 'datetime'
    ];

    public $timestamps = false;

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->dt_increased = now();
            $model->dt_decreased = now();
        });
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function canIncrease()
    {
        $allowIncreaseTime = now()->subMinutes($this->attribute->increase_interval);
        if (
            ($this->value < $this->attribute->max_value)
            && $this->dt_increased->lt($allowIncreaseTime)
        ) {
            return true;
        }
        return false;
    }

    public function canDecrease()
    {
        $allowDecreaseTime = now()->subMinutes($this->actualDecreaseIntervalAttribute());

        if (($this->attribute->name === Attribute::FOOD) && $this->value < $this->attribute->crtitcal_value) {
            return false;
        }

        return (
            ($this->value > $this->attribute->min_value)
            && $this->dt_decreased->lt($allowDecreaseTime)
        );
    }

    public function canDie()
    {
        $diedTime = now()->subMinutes($this->attribute->critical_interval);
        if ($this->attribute->name === Attribute::FOOD) {
            return ($this->value < $this->attribute->critical_value) && $this->dt_increased->lt($diedTime);
        }

        return false;
    }

    public function actualDecreaseIntervalAttribute()
    {
        if ($this->attribute->name == Attribute::CARE) {
            $sleepAttribute = AttributePet::where('pet_id', $this->pet_id)
                ->whereHas('attribute', function ($query) {
                    $query->where('name', Attribute::SLEEP);
                })->first();

            $sleepCriticalValue = $sleepAttribute->attribute->critical_value;
            return ($sleepAttribute->value < $sleepCriticalValue)
                ? $this->attribute->critical_interval : $this->attribute->decrease_interval;
        }
        return $this->attribute->decrease_interval;
    }
}
