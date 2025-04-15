<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisputeRequest extends FormRequest
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
            'reason' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'reason.required' => 'Reason is required',
            'reason.string' => 'Reason must be a string',
            'reason.max' => 'Reason cannot exceed 255 characters',
        ];
    }
}
