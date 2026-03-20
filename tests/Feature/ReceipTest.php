<?php

namespace Tests\Feature;

use App\Models\Receip;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReceipTest extends TestCase
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
        $this->get(route('receips.index'))->assertRedirect(route('login'));
    }

    // -------------------------------------------------------------------------
    // Index
    // -------------------------------------------------------------------------

    public function test_index_affiche_la_liste_des_recus(): void
    {
        Receip::factory()->count(3)->create();

        $this->actingAs($this->user)
            ->get(route('receips.index'))
            ->assertOk()
            ->assertViewIs('receips.index')
            ->assertViewHas('receips');
    }

    // -------------------------------------------------------------------------
    // Create / Store
    // -------------------------------------------------------------------------

    public function test_create_affiche_le_formulaire_avec_les_utilisateurs(): void
    {
        User::factory()->count(2)->create();

        $this->actingAs($this->user)
            ->get(route('receips.create'))
            ->assertOk()
            ->assertViewIs('receips.create')
            ->assertViewHas('users');
    }

    public function test_store_cree_un_recu(): void
    {
        $user = User::factory()->create();

        $this->actingAs($this->user)
            ->post(route('receips.store'), ['users_id' => $user->id])
            ->assertRedirect(route('receips.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('receips', ['users_id' => $user->id]);
    }

    public function test_store_echoue_si_utilisateur_inexistant(): void
    {
        $this->actingAs($this->user)
            ->post(route('receips.store'), ['users_id' => 9999])
            ->assertSessionHasErrors('users_id');
    }

    public function test_store_echoue_si_users_id_manquant(): void
    {
        $this->actingAs($this->user)
            ->post(route('receips.store'), [])
            ->assertSessionHasErrors('users_id');
    }

    // -------------------------------------------------------------------------
    // Show
    // -------------------------------------------------------------------------

    public function test_show_affiche_un_recu(): void
    {
        $receip = Receip::factory()->create();

        $this->actingAs($this->user)
            ->get(route('receips.show', $receip))
            ->assertOk()
            ->assertViewIs('receips.show')
            ->assertViewHas('receip', $receip);
    }

    public function test_show_retourne_404_si_inexistant(): void
    {
        $this->actingAs($this->user)
            ->get(route('receips.show', 9999))
            ->assertNotFound();
    }

    // -------------------------------------------------------------------------
    // Edit / Update
    // -------------------------------------------------------------------------

    public function test_edit_affiche_le_formulaire(): void
    {
        $receip = Receip::factory()->create();

        $this->actingAs($this->user)
            ->get(route('receips.edit', $receip))
            ->assertOk()
            ->assertViewIs('receips.edit')
            ->assertViewHas('receip', $receip);
    }

    public function test_update_modifie_le_recu(): void
    {
        $receip  = Receip::factory()->create();
        $newUser = User::factory()->create();

        $this->actingAs($this->user)
            ->put(route('receips.update', $receip), ['users_id' => $newUser->id])
            ->assertRedirect(route('receips.show', $receip))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('receips', [
            'id'       => $receip->id,
            'users_id' => $newUser->id,
        ]);
    }

    // -------------------------------------------------------------------------
    // Destroy
    // -------------------------------------------------------------------------

    public function test_destroy_supprime_un_recu(): void
    {
        $receip = Receip::factory()->create();

        $this->actingAs($this->user)
            ->delete(route('receips.destroy', $receip))
            ->assertRedirect(route('receips.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('receips', ['id' => $receip->id]);
    }
}