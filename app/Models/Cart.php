<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    
    protected $table = 'carts';

    protected $fillable = [
        'article_id',
        'number',
    ];

    protected $casts = [
        'article_id' => 'integer',
        'number'     => 'integer',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Relation : un panier peut être lié à plusieurs reçus (via cart_receip)
     */
    public function receips(): BelongsToMany
    {
        return $this->belongsToMany(Receip::class, 'cart_receip');
    }

    public function getTotalPriceAttribute(): float
    {
        return round($this->number * $this->article->price_ttc, 2);
    }
}