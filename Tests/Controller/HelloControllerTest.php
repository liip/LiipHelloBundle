<?php

namespace Liip\HelloBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/liip/hello/Lukas');

        $this->assertTrue($crawler->filter('html:contains("Hello Lukas")')->count() > 0);
    }
}
