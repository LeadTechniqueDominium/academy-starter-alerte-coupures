<?php

declare(strict_types=1);

it('affiche le formulaire de connexion des modérateurs', function () {
    $this->get('/connexion')
        ->assertOk()
        ->assertSee('Espace modérateur')
        ->assertSee('Mot de passe');
});

it('redirige un visiteur non connecté vers la connexion pour la modération', function () {
    $this->get('/moderation')->assertRedirect('/connexion');
});

it('envoie le modérateur sur la modération après la connexion', function () {
    $moderator = createModerator();

    $this->post('/connexion', ['email' => $moderator->email, 'password' => 'password'])
        ->assertRedirect(route('moderation.reports.index'));

    $this->assertAuthenticatedAs($moderator);
});

it('refuse un mauvais mot de passe avec un message clair', function () {
    $moderator = createModerator();

    $this->from('/connexion')
        ->post('/connexion', ['email' => $moderator->email, 'password' => 'mauvais'])
        ->assertRedirect('/connexion')
        ->assertSessionHasErrors(['email' => 'Ces identifiants ne correspondent pas à nos enregistrements.']);

    $this->assertGuest();
});

it('déconnecte le modérateur', function () {
    $this->actingAs(createModerator())
        ->post('/deconnexion')
        ->assertRedirect('/');

    $this->assertGuest();
});
