<?php

namespace Tests\AppBundle\Controller;

use Symfony\Component\HTTPFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private $client = null;
    private $usernameCreated = 'zetta86';
    private $usernameUpdated = 'zora.steuber';

    protected function setUp()
    {
        $this->client = $this->createClient();
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, array('_username' => 'Percevalseb', '_password' => 'azerty'));
    }

    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/users');
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains('Liste des utilisateurs', $crawler->filter('h1')->text());
    }

    public function testCreateAction()
    {
        $crawler = $this->client->request('GET', '/users');
        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $this->client->click($link);
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains('Créer un utilisateur', $crawler->filter('h1')->text());
        static::assertContains('/users/create', $crawler->filter('form')->attr('action'));
    }

    public function testCreateActionWithValidData()
    {
        $crawler = $this->client->request('GET', '/users/create');
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = $this->usernameCreated;
        $form['user[password][first]'] = 'v4SeJUbG';
        $form['user[password][second]'] = 'v4SeJUbG';
        $form['user[email]'] = 'emoen@yahoo.com';
        $form['user[roles][0]']->tick();
        $this->client->submit($form);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains("L'utilisateur a bien été ajouté.", $crawler->filter('div.alert-success')->text());
        static::assertSame(1, $crawler->filter('td:contains("'.$this->usernameCreated.'")')->count());
    }

    public function testCreateActionWithInvalidData()
    {
        $crawler = $this->client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = $this->usernameCreated;
        $form['user[password][first]'] = 'v4SeJUbG';
        $form['user[password][second]'] = 'TaNSgBSv';
        $form['user[email]'] = 'emoenyahoo.com';
        $crawler = $this->client->submit($form);
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertSame(1, $crawler->filter('span.help-block:contains("Ce nom d\'utilisateur existe déjà.")')->count());
        static::assertSame(1, $crawler->filter('span.help-block:contains("Les deux mots de passe doivent correspondre.")')->count());
        static::assertSame(1, $crawler->filter('span.help-block:contains("Le format de l\'adresse email n\'est pas correcte.")')->count());
        static::assertSame(1, $crawler->filter('span.help-block:contains("Vous devez cocher au moins un rôle.")')->count());
    }

    public function testEditAction()
    {
        $crawler = $this->client->request('GET', '/users');
        $link = $crawler->selectLink('Edit')->last()->link();
        $crawler = $this->client->click($link);
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains('Modifier', $crawler->filter('h1')->text());

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = $this->usernameUpdated;
        $form['user[password][first]'] = 'v4SeJUbG';
        $form['user[password][second]'] = 'v4SeJUbG';
        $this->client->submit($form);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains("L'utilisateur a bien été modifié.", $crawler->filter('div.alert-success')->text());
        static::assertSame(1, $crawler->filter('td:contains("'.$this->usernameUpdated.'")')->count());
    }
}
