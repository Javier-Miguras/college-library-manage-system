<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'name',
        'country_id'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function towns(): HasMany
    {
        return $this->hasMany(Town::class, 'city_id');
    }

    public function campus(): HasManyThrough
    {
        return $this->hasManyThrough(
            Campus::class,
            Town::class,
            'city_id',
            'town_id',
            'id',
            'id'
        );
    }
}
