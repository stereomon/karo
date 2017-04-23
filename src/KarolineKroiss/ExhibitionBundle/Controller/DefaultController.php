<?php

namespace KarolineKroiss\ExhibitionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $exhibitions = $this->getDoctrine()->getRepository('KarolineKroissExhibitionBundle:Exhibition')->findAll();

        return $this->render('KarolineKroissExhibitionBundle:Default:index.html.twig', ['exhibitions' => $exhibitions]);
    }
}
