<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    // -------------------------------------------------------------------------
    // Affichage du formulaire
    // -------------------------------------------------------------------------

    public function test_page_login_est_accessible(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_utilisateur_connecte_est_redirige_depuis_login(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('login'))
            ->assertRedirect(route('articles.index'));
    }

    // -------------------------------------------------------------------------
    // Connexion réussie
    // -------------------------------------------------------------------------

    public function test_connexion_avec_identifiants_valides(): void
    {
        $user = User::factory()->create([
            'email'    => 'test@example.com',
            'password' => bcrypt('monmotdepasse'),
        ]);

        $this->post(route('login'), [
            'email'    => 'test@example.com',
            'password' => 'monmotdepasse',
        ])
            ->assertRedirect(route('articles.index'))
            ->assertSessionHas('success');

        $this->assertAuthenticatedAs($user);
    }

    public function test_connexion_avec_remember_me(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password')]);

        $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'password',
            'remember' => '1',
        ])->assertRedirect(route('articles.index'));

        $this->assertAuthenticatedAs($user);
    }

    // -------------------------------------------------------------------------
    // Connexion échouée
    // -------------------------------------------------------------------------

    public function test_connexion_echoue_avec_mauvais_mot_de_passe(): void
    {
        User::factory()->create([
            'email'    => 'test@example.com',
            'password' => bcrypt('bonmotdepasse'),
        ]);

        $this->post(route('login'), [
            'email'    => 'test@example.com',
            'password' => 'mauvaismdp',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_connexion_echoue_avec_email_inconnu(): void
    {
        $this->post(route('login'), [
            'email'    => 'inconnu@example.com',
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_connexion_echoue_si_email_manquant(): void
    {
        $this->post(route('login'), ['password' => 'password'])
            ->assertSessionHasErrors('email');
    }

    public function test_connexion_echoue_si_email_invalide(): void
    {
        $this->post(route('login'), [
            'email'    => 'pas-un-email',
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }

    public function test_connexion_echoue_si_mot_de_passe_manquant(): void
    {
        $this->post(route('login'), ['email' => 'test@example.com'])
            ->assertSessionHasErrors('password');
    }

    // -------------------------------------------------------------------------
    // Déconnexion
    // -------------------------------------------------------------------------

    public function test_deconnexion_redirige_vers_login(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('login'))
            ->assertSessionHas('success');

        $this->assertGuest();
    }

    public function test_deconnexion_invalide_la_session(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('logout'));

        $this->assertFalse(Auth::check());
    }

    // -------------------------------------------------------------------------
    // Protection des routes
    // -------------------------------------------------------------------------

    public function test_routes_protegees_redirigent_vers_login(): void
    {
        $routes = [
            route('articles.index'),
            route('cart.index'),
            route('receips.index'),
            route('cart-receip.index'),
        ];

        foreach ($routes as $route) {
            $this->get($route)->assertRedirect(route('login'));
        }
    }

    public function test_routes_accessibles_apres_connexion(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('articles.index'))
            ->assertOk();
    }
}