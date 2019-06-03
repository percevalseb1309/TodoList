<?php
/**
 * @author Sébastien Rochat <percevalseb@gmail.com>
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultControllerTest
 * @package Tests\AppBundle\Controller
 */
class DefaultControllerTest extends WebTestCase
{
    public function testIndexAction()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        static::assertSame(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $crawler = $client->followRedirect();
        static::assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        static::assertContains('/login_check', $crawler->filter('form')->attr('action'));
    }
}
