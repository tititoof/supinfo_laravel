<?php

namespace App\Http\Requests;

class CommonArticleRequest 
{
    public static function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:255'],
            'nb_stock'       => ['required', 'integer', 'min:0'],
            'origin_country' => ['required', 'string', 'max:255'],
            'unit_price'     => ['required', 'numeric', 'min:0'],
            'discount'       => ['required', 'numeric', 'min:0', 'max:100'],
            'tva'            => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }
}