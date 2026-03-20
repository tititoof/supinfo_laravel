<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Cart;
use App\Models\Receip;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleModelTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Accessor price_ttc
    // -------------------------------------------------------------------------

    public function test_price_ttc_sans_remise(): void
    {
        $article = Article::factory()->make([
            'unit_price' => 10.00,
            'discount'   => 0,
            'tva'        => 20,
        ]);

        // 10 * 1.20 = 12.00
        $this->assertEquals(12.00, $article->price_ttc);
    }

    public function test_price_ttc_avec_remise(): void
    {
        $article = Article::factory()->make([
            'unit_price' => 100.00,
            'discount'   => 10,   // -10% → 90€ HT
            'tva'        => 20,   // +20% → 108€ TTC
        ]);

        $this->assertEquals(108.00, $article->price_ttc);
    }

    public function test_price_ttc_remise_totale(): void
    {
        $article = Article::factory()->make([
            'unit_price' => 50.00,
            'discount'   => 100,
            'tva'        => 20,
        ]);

        $this->assertEquals(0.00, $article->price_ttc);
    }

    public function test_price_ttc_est_arrondi_a_2_decimales(): void
    {
        $article = Article::factory()->make([
            'unit_price' => 9.99,
            'discount'   => 3,
            'tva'        => 5.5,
        ]);

        $expected = round(9.99 * 0.97 * 1.055, 2);
        $this->assertEquals($expected, $article->price_ttc);
    }

    // -------------------------------------------------------------------------
    // Scope inStock
    // -------------------------------------------------------------------------

    public function test_scope_in_stock_retourne_articles_disponibles(): void
    {
        Article::factory()->create(['nb_stock' => 5]);
        Article::factory()->create(['nb_stock' => 0]);
        Article::factory()->create(['nb_stock' => 1]);

        $results = Article::inStock()->get();

        $this->assertCount(2, $results);
        $results->each(fn ($a) => $this->assertGreaterThan(0, $a->nb_stock));
    }

    public function test_scope_in_stock_exclut_stock_zero(): void
    {
        $article = Article::factory()->create(['nb_stock' => 0]);

        $results = Article::inStock()->get();

        $this->assertFalse($results->contains($article));
    }

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function test_article_a_plusieurs_carts(): void
    {
        $article = Article::factory()->create();
        Cart::factory()->count(3)->create(['article_id' => $article->id]);

        $this->assertCount(3, $article->carts);
        $this->assertInstanceOf(Cart::class, $article->carts->first());
    }

    public function test_get_receips_retourne_les_recus_associes(): void
    {
        $article = Article::factory()->create();
        $cart    = Cart::factory()->create(['article_id' => $article->id]);
        $receip  = Receip::factory()->create();

        \App\Models\CartReceip::create([
            'cart_id'   => $cart->id,
            'receip_id' => $receip->id,
        ]);

        $receips = $article->getReceips();

        $this->assertCount(1, $receips);
        $this->assertEquals($receip->id, $receips->first()->id);
    }

    public function test_get_receips_retourne_vide_sans_associations(): void
    {
        $article = Article::factory()->create();

        $this->assertCount(0, $article->getReceips());
    }
}