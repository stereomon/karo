<?php

namespace WebPageBundle\Controller;

use WebPageBundle\FunctionalTester;

class CmsControllerCest
{

    /**
     * @return void
     */
    public function testContactPage(FunctionalTester $i)
    {
        $i->amOnPage('/kontakt');
        $i->see('Meine Kontaktdaten!');
    }

}
