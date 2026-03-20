<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';

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

    /**
     * Relation : les lignes de panier qui contiennent cet article
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
 
    /**
     * Relation : tous les reçus liés à cet article
     * Chemin : article → cart → cart_receip → receips
     *
     * Usage : $article->receips
     */
    public function receips(): BelongsToMany
    {
        return $this->belongsToMany(
                Receip::class,  // modèle cible
                'cart_receip',  // table pivot
                'cart_id',      // FK dans cart_receip (pointe vers cart)
                'receip_id',    // FK dans cart_receip (pointe vers receips)
            )
            ->join('cart', 'cart.id', '=', 'cart_receip.cart_id')
            ->where('cart.article_id', $this->id ?? 0)
            ->select('receips.*');
    }
 
    /**
     * Méthode alternative (sans join) : plus lisible, même résultat
     *
     * Usage : $article->getReceips()
     */
    public function getReceips()
    {
        $cartIds = $this->carts()->pluck('id');
 
        return Receip::whereHas('carts', fn ($q) =>
            $q->whereIn('carts.id', $cartIds)
        )->get();
    }
}