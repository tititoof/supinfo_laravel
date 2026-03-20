<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    // -------------------------------------------------------------------------
    // Authentification requise
    // -------------------------------------------------------------------------

    public function test_guest_est_redirige_vers_login(): void
    {
        $this->get(route('cart.index'))->assertRedirect(route('login'));
    }

    // -------------------------------------------------------------------------
    // Index
    // -------------------------------------------------------------------------

    public function test_index_affiche_le_panier(): void
    {
        $article = Article::factory()->create();
        Cart::factory()->create(['article_id' => $article->id]);

        $this->actingAs($this->user)
            ->get(route('cart.index'))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items');
    }

    public function test_index_affiche_le_total_ttc(): void
    {
        $article = Article::factory()->create([
            'unit_price' => 10.00,
            'discount'   => 0,
            'tva'        => 20,
        ]);
        Cart::factory()->create(['article_id' => $article->id, 'number' => 2]);

        $this->actingAs($this->user)
            ->get(route('cart.index'))
            ->assertOk()
            ->assertViewHas('total');
    }

    // -------------------------------------------------------------------------
    // Create / Store
    // -------------------------------------------------------------------------

    public function test_create_affiche_le_formulaire_avec_les_articles(): void
    {
        Article::factory()->count(3)->create();

        $this->actingAs($this->user)
            ->get(route('cart.create'))
            ->assertOk()
            ->assertViewIs('cart.create')
            ->assertViewHas('articles');
    }

    public function test_store_ajoute_un_article_au_panier(): void
    {
        $article = Article::factory()->create();

        $this->actingAs($this->user)
            ->post(route('cart.store'), [
                'article_id' => $article->id,
                'number'     => 3,
            ])
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('cart', [
            'article_id' => $article->id,
            'number'     => 3,
        ]);
    }

    public function test_store_echoue_si_article_inexistant(): void
    {
        $this->actingAs($this->user)
            ->post(route('cart.store'), [
                'article_id' => 9999,
                'number'     => 1,
            ])
            ->assertSessionHasErrors('article_id');
    }

    public function test_store_echoue_si_quantite_inferieure_a_1(): void
    {
        $article = Article::factory()->create();

        $this->actingAs($this->user)
            ->post(route('cart.store'), [
                'article_id' => $article->id,
                'number'     => 0,
            ])
            ->assertSessionHasErrors('number');
    }

    // -------------------------------------------------------------------------
    // Show
    // -------------------------------------------------------------------------

    public function test_show_affiche_une_ligne_de_panier(): void
    {
        $article = Article::factory()->create();
        $cart    = Cart::factory()->create(['article_id' => $article->id]);

        $this->actingAs($this->user)
            ->get(route('cart.show', $cart))
            ->assertOk()
            ->assertViewIs('cart.show')
            ->assertViewHas('cart', $cart);
    }

    // -------------------------------------------------------------------------
    // Edit / Update
    // -------------------------------------------------------------------------

    public function test_update_modifie_la_quantite(): void
    {
        $article = Article::factory()->create();
        $cart    = Cart::factory()->create(['article_id' => $article->id, 'number' => 1]);

        $this->actingAs($this->user)
            ->put(route('cart.update', $cart), [
                'article_id' => $article->id,
                'number'     => 5,
            ])
            ->assertRedirect(route('cart.show', $cart))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('cart', ['id' => $cart->id, 'number' => 5]);
    }

    // -------------------------------------------------------------------------
    // Destroy
    // -------------------------------------------------------------------------

    public function test_destroy_retire_un_article_du_panier(): void
    {
        $article = Article::factory()->create();
        $cart    = Cart::factory()->create(['article_id' => $article->id]);

        $this->actingAs($this->user)
            ->delete(route('cart.destroy', $cart))
            ->assertRedirect(route('cart.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('cart', ['id' => $cart->id]);
    }
}