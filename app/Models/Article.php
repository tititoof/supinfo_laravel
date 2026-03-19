<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'article';

    protected $fillable = [
        'name',
        'nb_stock',
        'origin_country',
        'unit_price',
        'discount',
        'tva',
    ];

    protected $casts = [
        'nb_stock'   => 'integer',
        'unit_price' => 'float',
        'discount'   => 'float',
        'tva'        => 'float',
    ];

    /**
     * Prix TTC après remise
     */
    public function getPriceTtcAttribute(): float
    {
        $priceAfterDiscount = $this->unit_price * (1 - $this->discount / 100);

        return round($priceAfterDiscount * (1 + $this->tva / 100), 2);
    }

    public function scopeInStock($query)
    {
        return $query->where('nb_stock', '>', 0);
    }
}