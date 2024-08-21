<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'place' => 'required|string|max:255',
            'time' => 'required|date_format:H:i',
            'price' => 'required|numeric|min:0',
            'organizer_id' => 'required|exists:organizers,id',
            'spots' => 'required|integer|min:1'
        ];
    }
}
