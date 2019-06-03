<?php
/**
 * @author Sébastien Rochat <percevalseb@gmail.com>
 */

namespace Tests\AppBundle\Controller;

use Symfony\Component\HTTPFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SecurityControllerTest
 * @package Tests\AppBundle\Controller
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * @var null
     */
    private $client = null;
    /**
     * @var null
     */
    private $crawler = null;

    protected function setUp()
    {
        $this->client = static::createClient();
        $this->crawler = $this->client->request('GET', '/login');
    }

    public function loginAction()
    {
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains('/login_check', $this->crawler->filter('form')->attr('action'));
    }

    public function testLoginActionWithValidUserData()
    {
        $form = $this->crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'John-Doe';
        $form['_password'] = 'azerty';
        $this->client->submit($form);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $this->crawler = $this->client->followRedirect();
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains('Bienvenue sur Todo List', $this->crawler->filter('h1')->text());

        $link = $this->crawler->selectLink('Se déconnecter')->link();
        $this->crawler = $this->client->click($link);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }

    public function testLoginActionWithValidAdminData()
    {
        $form = $this->crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'Percevalseb';
        $form['_password'] = 'azerty';
        $this->client->submit($form);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $this->crawler = $this->client->followRedirect();
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains('Bienvenue sur Todo List', $this->crawler->filter('h1')->text());

        $link = $this->crawler->selectLink('Consulter la liste des utilisateurs')->link();
        $this->crawler = $this->client->click($link);
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains('Liste des utilisateurs', $this->crawler->filter('h1')->text());
    }

    public function testLoginActionWithInvalidData()
    {
        $form = $this->crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'xxx';
        $form['_password'] = 'xxx';
        $this->client->submit($form);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $this->crawler = $this->client->followRedirect();
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains("Invalid credentials.", $this->crawler->filter('div.alert-danger')->text());
    }
}
