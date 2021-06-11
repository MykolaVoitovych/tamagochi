<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'food',
        'sleep',
        'care',
        'fun',
        'user_id',
        'food_at',
        'sleep_at',
        'care_at',
        'fun_at',
        'lower_food_at',
        'lower_sleep_at',
        'lower_care_at',
        'lower_fun_at',
        'is_died'
    ];

    protected $attributes = [
        'food' => 100,
        'sleep' => 100,
        'care' => 100,
        'fun' => 100,
        'is_died' => 0
    ];

    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'food' => 'integer',
        'sleep' => 'integer',
        'care' => 'integer',
        'fun' => 'integer',
        'user_id' => 'integer',
        'food_at' => 'datetime',
        'sleep_at' => 'datetime',
        'care_at' => 'datetime',
        'fun_at' => 'datetime',
        'lower_food_at' => 'datetime',
        'lower_sleep_at' => 'datetime',
        'lower_care_at' => 'datetime',
        'lower_fun_at' => 'datetime',
        'is_died' => 'boolean'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
     * Scopes
     */
    public function scopeIsAlive($query)
    {
        return $query->where('is_died', false);
    }

    public static function types()
    {
        return collect([
            [
                'title' => 'собака',
                'value' => 'dog',
            ],
            [
                'title' => 'кот',
                'value' => 'cat',
            ],
            [
                'title' => 'енот',
                'value' => 'raccoon',
            ],
            [
                'title' => 'пингвин',
                'value' => 'penguin',
            ],
        ]);
    }
}
