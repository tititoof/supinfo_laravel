<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'article_id' => ['required', 'integer', 'exists:article,id'],
            'number'     => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'article_id.required' => 'Veuillez sélectionner un article.',
            'article_id.exists'   => 'L\'article sélectionné n\'existe pas.',
            'number.required'     => 'La quantité est obligatoire.',
            'number.integer'      => 'La quantité doit être un entier.',
            'number.min'          => 'La quantité doit être au moins 1.',
        ];
    }
}