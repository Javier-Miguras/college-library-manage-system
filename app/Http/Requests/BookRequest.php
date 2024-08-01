<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
        $bookId = $this->route('book')->id ?? null;
        $actualYear = Carbon::now()->format('Y');

        return [
            'isbn' => ['required', 'string', 'unique:books,isbn,' . $bookId],
            'author_id' => ['required', 'integer', 'exists:authors,id'],
            'title' => ['required', 'string', 'max:100'],
            'summary' => ['required', 'string', 'min:60', 'max:500'],
            'publication_year' => ['required', 'integer', 'max:' . $actualYear, 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id']
        ];
    }
}
