<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Rating is required',
            'rating.integer' => 'Rating must be an integer',
            'rating.min' => 'Rating must be at least 1',
            'rating.max' => 'Rating cannot exceed 5',
            'comment.required' => 'Comment is required',
            'comment.string' => 'Comment must be a string',
            'comment.max' => 'Comment cannot exceed 255 characters',
        ];
    }
}