<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Cart;
use App\Models\Receip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartModelTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Accessor total_price
    // -------------------------------------------------------------------------

    public function test_total_price_calcule_correctement(): void
    {
        $article = Article::factory()->create([
            'unit_price' => 10.00,
            'discount'   => 0,
            'tva'        => 20,
        ]);
        $cart = Cart::factory()->create([
            'article_id' => $article->id,
            'number'     => 3,
        ]);

        // prix TTC = 12.00 ; total = 3 * 12.00 = 36.00
        $this->assertEquals(36.00, $cart->total_price);
    }

    public function test_total_price_avec_remise(): void
    {
        $article = Article::factory()->create([
            'unit_price' => 100.00,
            'discount'   => 10,
            'tva'        => 20,
        ]);
        $cart = Cart::factory()->create([
            'article_id' => $article->id,
            'number'     => 2,
        ]);

        // prix TTC = 108.00 ; total = 2 * 108 = 216.00
        $this->assertEquals(216.00, $cart->total_price);
    }

    public function test_total_price_est_arrondi(): void
    {
        $article = Article::factory()->create([
            'unit_price' => 9.99,
            'discount'   => 3,
            'tva'        => 5.5,
        ]);
        $cart = Cart::factory()->create([
            'article_id' => $article->id,
            'number'     => 4,
        ]);

        $priceTtc = round(9.99 * 0.97 * 1.055, 2);
        $expected = round(4 * $priceTtc, 2);

        $this->assertEquals($expected, $cart->total_price);
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function test_cart_appartient_a_un_article(): void
    {
        $article = Article::factory()->create();
        $cart    = Cart::factory()->create(['article_id' => $article->id]);

        $this->assertInstanceOf(Article::class, $cart->article);
        $this->assertEquals($article->id, $cart->article->id);
    }

    public function test_cart_a_plusieurs_recus(): void
    {
        $article  = Article::factory()->create();
        $cart     = Cart::factory()->create(['article_id' => $article->id]);
        $receip1  = Receip::factory()->create();
        $receip2  = Receip::factory()->create();

        \App\Models\CartReceip::create(['cart_id' => $cart->id, 'receip_id' => $receip1->id]);
        \App\Models\CartReceip::create(['cart_id' => $cart->id, 'receip_id' => $receip2->id]);

        $this->assertCount(2, $cart->receips);
    }
}