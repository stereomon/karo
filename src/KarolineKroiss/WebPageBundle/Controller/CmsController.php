<?php

namespace KarolineKroiss\WebPageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CmsController extends Controller
{
    public function contactAction()
    {
        $page = $this->getDoctrine()->getRepository('KarolineKroissWebPageBundle:CmsPage')->getPageByName('contact');
        return $this->render('KarolineKroissWebPageBundle:Cms:index.html.twig', ['page' => $page, 'name' => 'Kontakt']);
    }

    public function vitaAction()
    {
        $page = $this->getDoctrine()->getRepository('KarolineKroissWebPageBundle:CmsPage')->getPageByName('vita');
        return $this->render('KarolineKroissWebPageBundle:Cms:index.html.twig', ['page' => $page, 'name' => 'Lebenslauf']);
    }

    public function imprintAction()
    {
        $page = $this->getDoctrine()->getRepository('KarolineKroissWebPageBundle:CmsPage')->getPageByName('imprint');
        return $this->render('KarolineKroissWebPageBundle:Cms:index.html.twig', ['page' => $page, 'name' => 'Impressum']);
    }
}
