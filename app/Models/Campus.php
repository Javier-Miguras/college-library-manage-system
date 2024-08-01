<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Campus extends Model
{
    use HasFactory;

    protected $table = 'campus';

    protected $fillable = [
        'town_id'
    ];

    public function town(): BelongsTo
    {
        return $this->belongsTo(Town::class);
    }

    public function city(): HasOneThrough
    {
        return $this->hasOneThrough(
            City::class,
            Town::class,
            'id',
            'id',
            'town_id',
            'city_id'
        );
    }

    public function programs(): HasManyThrough
    {
        return $this->hasManyThrough(
            AcademicProgram::class,
            CampusProgram::class,
            'campus_id',
            'id',
            'id',
            'program_id'
        );
    }

    public function booksStock(): HasMany
    {
        return $this->hasMany(BookStock::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
