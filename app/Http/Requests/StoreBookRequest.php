<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
        return [
            'author_id' => 'integer|required',
            'title' => 'string|required',
            'release_date' => 'string|required',
            'description' => 'string|required',
            'isbn' => 'string|required',
            'format' => 'string|required',
            'number_of_pages' => 'integer|required',
        ];
    }
}
