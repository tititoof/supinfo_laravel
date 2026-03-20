<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
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
        $this->get(route('articles.index'))->assertRedirect(route('login'));
    }

    // -------------------------------------------------------------------------
    // Index
    // -------------------------------------------------------------------------

    public function test_index_affiche_la_liste_des_articles(): void
    {
        Article::factory()->count(3)->create();

        $this->actingAs($this->user)
            ->get(route('articles.index'))
            ->assertOk()
            ->assertViewIs('articles.index')
            ->assertViewHas('articles');
    }

    public function test_index_est_vide_quand_aucun_article(): void
    {
        $this->actingAs($this->user)
            ->get(route('articles.index'))
            ->assertOk()
            ->assertSee('Aucun article');
    }

    // -------------------------------------------------------------------------
    // Create / Store
    // -------------------------------------------------------------------------

    public function test_create_affiche_le_formulaire(): void
    {
        $this->actingAs($this->user)
            ->get(route('articles.create'))
            ->assertOk()
            ->assertViewIs('articles.create');
    }

    public function test_store_cree_un_article_valide(): void
    {
        $data = [
            'name'           => 'Tomate cerise',
            'nb_stock'       => 100,
            'origin_country' => 'France',
            'unit_price'     => 2.50,
            'discount'       => 10,
            'tva'            => 20,
        ];

        $this->actingAs($this->user)
            ->post(route('articles.store'), $data)
            ->assertRedirect(route('articles.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('article', ['name' => 'Tomate cerise']);
    }

    public function test_store_echoue_si_nom_manquant(): void
    {
        $this->actingAs($this->user)
            ->post(route('articles.store'), ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    public function test_store_echoue_si_stock_negatif(): void
    {
        $this->actingAs($this->user)
            ->post(route('articles.store'), [
                'name'           => 'Test',
                'nb_stock'       => -5,
                'origin_country' => 'France',
                'unit_price'     => 1.00,
                'discount'       => 0,
                'tva'            => 20,
            ])
            ->assertSessionHasErrors('nb_stock');
    }

    public function test_store_echoue_si_remise_superieure_a_100(): void
    {
        $this->actingAs($this->user)
            ->post(route('articles.store'), [
                'name'           => 'Test',
                'nb_stock'       => 10,
                'origin_country' => 'France',
                'unit_price'     => 1.00,
                'discount'       => 150,
                'tva'            => 20,
            ])
            ->assertSessionHasErrors('discount');
    }

    // -------------------------------------------------------------------------
    // Show
    // -------------------------------------------------------------------------

    public function test_show_affiche_un_article(): void
    {
        $article = Article::factory()->create(['name' => 'Poivron rouge']);

        $this->actingAs($this->user)
            ->get(route('articles.show', $article))
            ->assertOk()
            ->assertViewIs('articles.show')
            ->assertSee('Poivron rouge');
    }

    public function test_show_retourne_404_si_inexistant(): void
    {
        $this->actingAs($this->user)
            ->get(route('articles.show', 9999))
            ->assertNotFound();
    }

    // -------------------------------------------------------------------------
    // Edit / Update
    // -------------------------------------------------------------------------

    public function test_edit_affiche_le_formulaire_avec_les_donnees(): void
    {
        $article = Article::factory()->create();

        $this->actingAs($this->user)
            ->get(route('articles.edit', $article))
            ->assertOk()
            ->assertViewIs('articles.edit')
            ->assertViewHas('article', $article);
    }

    public function test_update_modifie_un_article(): void
    {
        $article = Article::factory()->create(['name' => 'Ancien nom']);

        $this->actingAs($this->user)
            ->put(route('articles.update', $article), [
                'name'           => 'Nouveau nom',
                'nb_stock'       => 50,
                'origin_country' => 'Espagne',
                'unit_price'     => 3.00,
                'discount'       => 5,
                'tva'            => 20,
            ])
            ->assertRedirect(route('articles.show', $article))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('article', ['name' => 'Nouveau nom']);
        $this->assertDatabaseMissing('article', ['name' => 'Ancien nom']);
    }

    public function test_update_echoue_avec_donnees_invalides(): void
    {
        $article = Article::factory()->create();

        $this->actingAs($this->user)
            ->put(route('articles.update', $article), ['name' => ''])
            ->assertSessionHasErrors('name');
    }

    // -------------------------------------------------------------------------
    // Destroy
    // -------------------------------------------------------------------------

    public function test_destroy_supprime_un_article(): void
    {
        $article = Article::factory()->create();

        $this->actingAs($this->user)
            ->delete(route('articles.destroy', $article))
            ->assertRedirect(route('articles.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('article', ['id' => $article->id]);
    }

    public function test_destroy_retourne_404_si_inexistant(): void
    {
        $this->actingAs($this->user)
            ->delete(route('articles.destroy', 9999))
            ->assertNotFound();
    }
}