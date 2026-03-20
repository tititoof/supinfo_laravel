<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Cart;
use App\Models\CartReceip;
use App\Models\Receip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceipModelTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Relations
    // -------------------------------------------------------------------------

    public function test_receip_appartient_a_un_user(): void
    {
        $user   = User::factory()->create();
        $receip = Receip::factory()->create(['users_id' => $user->id]);

        $this->assertInstanceOf(User::class, $receip->user);
        $this->assertEquals($user->id, $receip->user->id);
    }

    public function test_receip_a_plusieurs_carts(): void
    {
        $receip   = Receip::factory()->create();
        $article  = Article::factory()->create();
        $cart1    = Cart::factory()->create(['article_id' => $article->id]);
        $cart2    = Cart::factory()->create(['article_id' => $article->id]);

        CartReceip::create(['cart_id' => $cart1->id, 'receip_id' => $receip->id]);
        CartReceip::create(['cart_id' => $cart2->id, 'receip_id' => $receip->id]);

        $this->assertCount(2, $receip->carts);
    }

    // -------------------------------------------------------------------------
    // getArticles()
    // -------------------------------------------------------------------------

    public function test_get_articles_retourne_les_articles_du_recu(): void
    {
        $receip   = Receip::factory()->create();
        $article1 = Article::factory()->create();
        $article2 = Article::factory()->create();

        $cart1 = Cart::factory()->create(['article_id' => $article1->id]);
        $cart2 = Cart::factory()->create(['article_id' => $article2->id]);

        CartReceip::create(['cart_id' => $cart1->id, 'receip_id' => $receip->id]);
        CartReceip::create(['cart_id' => $cart2->id, 'receip_id' => $receip->id]);

        $articles = $receip->getArticles();

        $this->assertCount(2, $articles);
        $this->assertTrue($articles->contains('id', $article1->id));
        $this->assertTrue($articles->contains('id', $article2->id));
    }

    public function test_get_articles_retourne_vide_sans_carts(): void
    {
        $receip = Receip::factory()->create();

        $this->assertCount(0, $receip->getArticles());
    }

    public function test_get_articles_ne_retourne_pas_articles_dautres_recus(): void
    {
        $receip1  = Receip::factory()->create();
        $receip2  = Receip::factory()->create();
        $article1 = Article::factory()->create();
        $article2 = Article::factory()->create();

        $cart1 = Cart::factory()->create(['article_id' => $article1->id]);
        $cart2 = Cart::factory()->create(['article_id' => $article2->id]);

        CartReceip::create(['cart_id' => $cart1->id, 'receip_id' => $receip1->id]);
        CartReceip::create(['cart_id' => $cart2->id, 'receip_id' => $receip2->id]);

        $articles = $receip1->getArticles();

        $this->assertCount(1, $articles);
        $this->assertEquals($article1->id, $articles->first()->id);
    }
}