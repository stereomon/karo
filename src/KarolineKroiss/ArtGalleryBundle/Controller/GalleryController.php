<?php

namespace KarolineKroiss\ArtGalleryBundle\Controller;

use Doctrine\Common\Util\Debug;
use KarolineKroiss\GalleryBundle\Entity\GalleryImage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GalleryController extends Controller
{

    /**
     * @param $type
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $galleries = $this->getDoctrine()->getRepository('KarolineKroissArtGalleryBundle:Gallery')->findAll();
        return $this->render('KarolineKroissArtGalleryBundle:Gallery:list.html.twig', ['galleries' => $galleries]);
    }
}
