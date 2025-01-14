<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'name' => 'required|String|min:2|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|String|min:6',
            'age'=> 'required|integer|min:18|max:100',
            'role' => 'required|string|in:attendee,organizer',
        ];
    }

    public function messages() {
        return [
            'role.in' => "The role should be either organizer or attendee"
        ];
    }

}
