<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueCampusProgram implements ValidationRule
{
    protected $campus_id;
    protected $program_id;

    public function __construct($campus_id, $program_id)
    {
        $this->campus_id = $campus_id;
        $this->program_id = $program_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table('campus_programs')->where('campus_id', $this->campus_id)->where('program_id', $this->program_id)->exists();

        if($exists){
            $fail('The selected program already exists for this campus.');
        }
    }
}
