<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return CommonArticleRequest::rules();
        // return [
        //     'name'           => ['required', 'string', 'max:255'],
        //     'nb_stock'       => ['required', 'integer', 'min:0'],
        //     'origin_country' => ['required', 'string', 'max:255'],
        //     'unit_price'     => ['required', 'numeric', 'min:0'],
        //     'discount'       => ['required', 'numeric', 'min:0', 'max:100'],
        //     'tva'            => ['required', 'numeric', 'min:0', 'max:100'],
        // ];
    }

    public function messages(): array
    {
        return [
            'name.required'           => 'Le nom de l\'article est obligatoire.',
            'name.max'                => 'Le nom ne peut pas dépasser 255 caractères.',
            'nb_stock.required'       => 'La quantité en stock est obligatoire.',
            'nb_stock.integer'        => 'La quantité en stock doit être un entier.',
            'nb_stock.min'            => 'La quantité en stock ne peut pas être négative.',
            'origin_country.required' => 'Le pays d\'origine est obligatoire.',
            'unit_price.required'     => 'Le prix unitaire est obligatoire.',
            'unit_price.min'          => 'Le prix unitaire ne peut pas être négatif.',
            'discount.required'       => 'La remise est obligatoire.',
            'discount.min'            => 'La remise ne peut pas être négative.',
            'discount.max'            => 'La remise ne peut pas dépasser 100%.',
            'tva.required'            => 'La TVA est obligatoire.',
            'tva.min'                 => 'La TVA ne peut pas être négative.',
            'tva.max'                 => 'La TVA ne peut pas dépasser 100%.',
        ];
    }
}