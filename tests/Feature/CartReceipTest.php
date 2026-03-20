<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Cart;
use App\Models\CartReceip;
use App\Models\Receip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartReceipTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function makeCart(): Cart
    {
        $article = Article::factory()->create();
        return Cart::factory()->create(['article_id' => $article->id]);
    }

    private function makeReceip(): Receip
    {
        return Receip::factory()->create();
    }

    // -------------------------------------------------------------------------
    // Authentification requise
    // -------------------------------------------------------------------------

    public function test_guest_est_redirige_vers_login(): void
    {
        $this->get(route('cart-receip.index'))->assertRedirect(route('login'));
    }

    // -------------------------------------------------------------------------
    // Index
    // -------------------------------------------------------------------------

    public function test_index_affiche_les_associations(): void
    {
        $cart   = $this->makeCart();
        $receip = $this->makeReceip();
        CartReceip::factory()->create(['cart_id' => $cart->id, 'receip_id' => $receip->id]);

        $this->actingAs($this->user)
            ->get(route('cart-receip.index'))
            ->assertOk()
            ->assertViewIs('cart-receip.index')
            ->assertViewHas('entries');
    }

    // -------------------------------------------------------------------------
    // Create / Store
    // -------------------------------------------------------------------------

    public function test_create_affiche_le_formulaire(): void
    {
        $this->actingAs($this->user)
            ->get(route('cart-receip.create'))
            ->assertOk()
            ->assertViewIs('cart-receip.create')
            ->assertViewHas('carts')
            ->assertViewHas('receips');
    }

    public function test_store_cree_une_association(): void
    {
        $cart   = $this->makeCart();
        $receip = $this->makeReceip();

        $this->actingAs($this->user)
            ->post(route('cart-receip.store'), [
                'cart_id'   => $cart->id,
                'receip_id' => $receip->id,
            ])
            ->assertRedirect(route('cart-receip.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('cart_receip', [
            'cart_id'   => $cart->id,
            'receip_id' => $receip->id,
        ]);
    }

    public function test_store_echoue_si_doublon(): void
    {
        $cart   = $this->makeCart();
        $receip = $this->makeReceip();
        CartReceip::factory()->create(['cart_id' => $cart->id, 'receip_id' => $receip->id]);

        $this->actingAs($this->user)
            ->post(route('cart-receip.store'), [
                'cart_id'   => $cart->id,
                'receip_id' => $receip->id,
            ])
            ->assertSessionHasErrors('receip_id');
    }

    public function test_store_echoue_si_cart_inexistant(): void
    {
        $receip = $this->makeReceip();

        $this->actingAs($this->user)
            ->post(route('cart-receip.store'), [
                'cart_id'   => 9999,
                'receip_id' => $receip->id,
            ])
            ->assertSessionHasErrors('cart_id');
    }

    public function test_store_echoue_si_receip_inexistant(): void
    {
        $cart = $this->makeCart();

        $this->actingAs($this->user)
            ->post(route('cart-receip.store'), [
                'cart_id'   => $cart->id,
                'receip_id' => 9999,
            ])
            ->assertSessionHasErrors('receip_id');
    }

    // -------------------------------------------------------------------------
    // Show
    // -------------------------------------------------------------------------

    public function test_show_affiche_une_association(): void
    {
        $cart       = $this->makeCart();
        $receip     = $this->makeReceip();
        $cartReceip = CartReceip::factory()->create([
            'cart_id'   => $cart->id,
            'receip_id' => $receip->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('cart-receip.show', $cartReceip))
            ->assertOk()
            ->assertViewIs('cart-receip.show')
            ->assertViewHas('cartReceip');
    }

    // -------------------------------------------------------------------------
    // Edit / Update
    // -------------------------------------------------------------------------

    public function test_update_modifie_une_association(): void
    {
        $cart       = $this->makeCart();
        $receip     = $this->makeReceip();
        $cartReceip = CartReceip::factory()->create([
            'cart_id'   => $cart->id,
            'receip_id' => $receip->id,
        ]);

        $newCart   = $this->makeCart();
        $newReceip = $this->makeReceip();

        $this->actingAs($this->user)
            ->put(route('cart-receip.update', $cartReceip), [
                'cart_id'   => $newCart->id,
                'receip_id' => $newReceip->id,
            ])
            ->assertRedirect(route('cart-receip.show', $cartReceip))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('cart_receip', [
            'id'        => $cartReceip->id,
            'cart_id'   => $newCart->id,
            'receip_id' => $newReceip->id,
        ]);
    }

    // -------------------------------------------------------------------------
    // Destroy
    // -------------------------------------------------------------------------

    public function test_destroy_supprime_une_association(): void
    {
        $cart       = $this->makeCart();
        $receip     = $this->makeReceip();
        $cartReceip = CartReceip::factory()->create([
            'cart_id'   => $cart->id,
            'receip_id' => $receip->id,
        ]);

        $this->actingAs($this->user)
            ->delete(route('cart-receip.destroy', $cartReceip))
            ->assertRedirect(route('cart-receip.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('cart_receip', ['id' => $cartReceip->id]);
    }
}