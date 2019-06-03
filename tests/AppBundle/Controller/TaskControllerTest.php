<?php
/**
 * @author Sébastien Rochat <percevalseb@gmail.com>
 */

namespace Tests\AppBundle\Controller;

use Symfony\Component\HTTPFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class TaskControllerTest
 * @package Tests\AppBundle\Controller
 */
class TaskControllerTest extends WebTestCase
{
    /**
     * @var null
     */
    private $client = null;
    /**
     * @var string
     */
    private $username = 'John-Doe';
    /**
     * @var string
     */
    private $titleCreated = 'Tâche lambda';
    /**
     * @var string
     */
    private $titleUpdated = 'Tâche bêta';

    protected function setUp()
    {
        $this->client = $this->createClient();
        $crawler = $this->client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $this->client->submit($form, array('_username' => $this->username, '_password' => 'azerty'));
    }

    public function testListAction()
    {
        $crawler = $this->client->request('GET', '/');
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $this->client->click($link);
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains('Liste des tâches', $crawler->filter('h1')->text());
    }

    public function testCreateAction()
    {
        $crawler = $this->client->request('GET', '/tasks');
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $link = $crawler->selectLink('Créer une tâche')->link();
        $crawler = $this->client->click($link);
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains('Créer une tâche', $crawler->filter('h1')->text());
        static::assertContains('/tasks/create', $crawler->filter('form')->attr('action'));
    }

    public function testCreateActionWithValidData()
    {
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = $this->titleCreated;
        $form['task[content]'] = 'Faire les courses';
        $this->client->submit($form);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains("La tâche a été bien été ajoutée.", $crawler->filter('div.alert-success')->text());
        static::assertSame(1, $crawler->filter('h4:contains("'.$this->titleCreated.'")')->count());
        static::assertSame($this->username, $crawler->filter('h4:contains("'.$this->titleCreated.'")')->siblings()->last()->text());
    }

    public function testCreateActionWithInvalidData()
    {
        $crawler = $this->client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = $this->titleCreated;
        $form['task[content]'] = '';
        $crawler = $this->client->submit($form);
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertSame(1, $crawler->filter('span.help-block:contains("Ce nom de tâche existe déjà.")')->count());
        static::assertSame(1, $crawler->filter('span.help-block:contains("Vous devez saisir du contenu.")')->count());
    }

    public function testEditActionWithValidData()
    {
        $crawler = $this->client->request('GET', '/tasks');
        $link = $crawler->selectLink('Tâche lambda')->link();
        $crawler = $this->client->click($link);
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains('Modifier '.$this->titleCreated, $crawler->filter('h1')->text());
        static::assertRegExp('/tasks\/([0-9]*)\/edit/', $crawler->filter('form')->attr('action'));

        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = $this->titleUpdated;
        $this->client->submit($form);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains("La tâche a bien été modifiée.", $crawler->filter('div.alert-success')->text());
        static::assertSame(1, $crawler->filter('h4:contains("'.$this->titleUpdated.'")')->count());
        static::assertSame($this->username, $crawler->filter('h4:contains("'.$this->titleUpdated.'")')->siblings()->last()->text());
    }

    public function testToggleTaskAction()
    {
        $crawler = $this->client->request('GET', '/tasks');

        $form = $crawler->selectButton('Marquer comme faite')->last()->form();
        $this->client->submit($form);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertRegExp("/La tâche (.*) a bien été marquée comme faite./", $crawler->filter('div.alert-success')->text());

        $form = $crawler->selectButton('Marquer non terminée')->last()->form();
        $this->client->submit($form);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertRegExp("/La tâche (.*) a bien été marquée comme non terminée./", $crawler->filter('div.alert-success')->text());
    }

    public function testDeleteAction()
    {
        $crawler = $this->client->request('GET', '/tasks');

        $nbThumbnailsBeforeDelete = $crawler->filter('div.thumbnail')->count();

        $form = $crawler->selectButton('Supprimer')->last()->form();
        $this->client->submit($form);
        static::assertSame(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());

        $crawler = $this->client->followRedirect();
        static::assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        static::assertContains("La tâche a bien été supprimée.", $crawler->filter('div.alert-success')->text());
        static::assertSame($nbThumbnailsBeforeDelete-1, $crawler->filter('div.thumbnail')->count());
    }

    public function testAuthorizationDeletion()
    {
        $crawler = $this->client->request('GET', '/tasks');

        static::assertSame(
            $crawler->filter('div.thumbnail:contains("'.$this->username.'")')->count(),
            $crawler->filter('div.thumbnail:contains("'.$this->username.'")')->filter('button:contains("Supprimer")')->count()
        );
    }
}
