<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = [
        'name'
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'country_id');
    }

    public function towns(): HasManyThrough
    {
        return $this->hasManyThrough(
            Town::class,
            City::class,
            'country_id',
            'city_id',
            'id',
            'id'
        );
    }
}
