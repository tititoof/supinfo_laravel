<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receip extends Model
{
    use HasFactory;

    protected $table = 'receips';

    protected $fillable = [
        'users_id',
    ];

    protected $casts = [
        'users_id' => 'integer',
    ];

    /**
     * Relation : appartient à un utilisateur
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Relation : un reçu contient plusieurs lignes de panier (via cart_receip)
     */
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_receip');
    }

    /**
     * Relation : tous les articles liés à ce reçu
     * Chemin : receips → cart_receip → cart → article
     *
     * Usage : $receip->articles
     */
    public function articles(): BelongsToMany
    {
        // On joint cart pour remonter jusqu'à article_id
        return $this->belongsToMany(
                Article::class,   // modèle cible
                'cart_receip',    // table pivot
                'receip_id',      // FK vers receips dans cart_receip
                'article_id',     // FK vers article dans cart (via join)
            )
            ->join('cart', 'cart.id', '=', 'cart_receip.cart_id')
            ->select('article.*', 'cart.number as cart_number');
    }

    /**
     * Méthode alternative (sans join) : plus lisible, même résultat
     *
     * Usage : $receip->getArticles()
     */
    public function getArticles()
    {
        $articleIds = $this->carts()->pluck('cart.article_id');

        return Article::whereIn('id', $articleIds)->get();
    }
}