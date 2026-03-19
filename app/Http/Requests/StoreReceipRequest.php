<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReceipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'users_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'users_id.required' => 'Veuillez sélectionner un utilisateur.',
            'users_id.exists'   => 'L\'utilisateur sélectionné n\'existe pas.',
        ];
    }
}