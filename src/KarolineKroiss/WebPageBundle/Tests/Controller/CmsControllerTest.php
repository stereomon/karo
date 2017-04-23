<?php

namespace KarolineKroiss\WebPageBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CmsControllerTest extends WebTestCase
{

    /**
     * @return void
     */
    public function testContactPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/kontakt');

        $this->assertTrue($crawler->filter('html:contains("Meine Kontaktdaten!")')->count() > 0);
    }

}
