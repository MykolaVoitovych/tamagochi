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
        'user_id',
        'is_died'
    ];

    protected $appends = [
        'attributes'
    ];

    protected $attributes = [
        'is_died' => 0
    ];

    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'user_id' => 'integer',
        'is_died' => 'boolean'
    ];

    protected $with = [
        'attributes'
    ];

    public $timestamps = false;

    protected static function booted()
    {
        static::created(function ($pet) {
            $petAttributes = [];
            foreach (Attribute::all() as $attribute) {
                $petAttributes[$attribute->id] = ['value' => $attribute->max_value];
            }
            $pet->attributes()->sync($petAttributes);
        });
    }

    public function getAttributesAttribute()
    {
        return $this->attributes;
    }

    /*
     * Relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
            ->using(AttributePet::class)
            ->withPivot('value', 'dt_decreased', 'dt_increased');
    }

    /*
     * Scopes
     */
    public function scopeIsAlive($query)
    {
        return $query->where('is_died', false);
    }

    public function getAttributeByName($attributeName)
    {
        return $this->attributes()->firstWhere('name', $attributeName);
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
