<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartReceip extends Model
{
    use HasFactory;

    protected $table = 'cart_receip';

    protected $fillable = [
        'cart_id',
        'receip_id',
    ];

    protected $casts = [
        'cart_id'   => 'integer',
        'receip_id' => 'integer',
    ];

    /**
     * Relation : appartient à un panier
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Relation : appartient à un reçu
     */
    public function receip(): BelongsTo
    {
        return $this->belongsTo(Receip::class);
    }
}