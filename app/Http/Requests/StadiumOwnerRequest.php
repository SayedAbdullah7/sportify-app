<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StadiumOwnerRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
        ];

        // Check if the 'phone' field exists in the request (for updates) and add the 'ignore' rule if needed.
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['phone'] = 'required|max:25'; // Allow the same phone number during an update.
        } else {
            $rules['phone'] = 'required|unique:stadium_owners|max:25'; // Enforce uniqueness for new records.
        }

        return $rules;
    }
}
