<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('user')->id ?? null;

        return [
            'name' => ['required', 'string', 'max:60'],
            'lastname' => ['required', 'string', 'max:60'],
            'email' => ['required', 'email', 'unique:users,email,' . $userId],
            'password' => ['nullable', 'confirmed', Password::min(8)->numbers()->symbols()],
            'role' => ['required', 'integer', 'in:0,1,2'],
            'campus_id' => ['nullable', 'integer', 'exists:campus,id'],
            'program_id' => ['nullable', 'integer', 'exists:academic_programs,id']
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('campus_id', 'required', function ($input) {
            return in_array($input->role, [0, 1]);
        });

        $validator->sometimes('program_id', 'required', function ($input) {
            return in_array($input->role, [0]);
        });
    }
}
