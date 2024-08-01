<?php

namespace App\Http\Requests;

use App\Rules\UniqueCampusProgram;
use Illuminate\Foundation\Http\FormRequest;

class CampusProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $campusId = $this->input('campus_id');
        $programId = $this->input('program_id');

        return [
            'campus_id' => ['required', 'integer', 'exists:campus,id'],
            'program_id' => ['required', 'integer', 'exists:academic_programs,id', new UniqueCampusProgram($campusId, $programId)]
        ];
    }
}
