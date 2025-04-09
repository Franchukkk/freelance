<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BidRequest extends FormRequest
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
            'bid_amount' => 'required|numeric',
            'deadline_time' => 'required|numeric',
            'message' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'bid_amount.required' => 'Bid amount is required',
            'bid_amount.numeric' => 'Bid amount must be a number',
            'deadline_time.required' => 'Deadline time is required',
            'deadline_time.numeric' => 'Deadline time must be a number',
            'message.required' => 'Message is required',
            'message.string' => 'Message must be a string',
        ];
    }
}
