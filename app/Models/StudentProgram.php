<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentProgram extends Model
{
    use HasFactory;

    protected $table = 'students_programs';

    protected $fillable = [
        'matriculation_date',
        'student_id',
        'program_id',
        'campus_id'
    ];

    public function student(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'student_id');
    }

    public function program(): HasOne
    {
        return $this->hasOne(AcademicProgram::class, 'id', 'program_id');
    }
}
