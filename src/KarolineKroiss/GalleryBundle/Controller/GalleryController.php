<?php

namespace KarolineKroiss\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GalleryController extends Controller
{

    /**
     * @param string $type
     * @param int $year
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showByTypeAndYearAction($type, $year)
    {
        $gallery = $this->getGalleryRepository()->findByTypeAndYear($type, $year);

        $viewData = [
            'similarImages' => false,
        ];
        if ($gallery) {
            $viewData['gallery'] = $gallery;
            $viewData['type'] = $this->mapTypeToName($gallery->getType());
        }

        return $this->render('KarolineKroissGalleryBundle:Gallery:show.html.twig', $viewData);
    }

    /**
     * @param string $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showSimilarAction($name)
    {
        $galleryImage = $this->getGalleryImageRepository()->findByName($name);

        return $this->render('KarolineKroissGalleryBundle:Gallery:show.html.twig', [
            'images' => $galleryImage->getSimilarImages(),
            'similarImages' => true
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function firstGalleryAction()
    {
        $homepageGallery = $this->getGalleryRepository()->getHomepageGallery();

        $viewData = [];
        if ($homepageGallery) {
            $viewData = [
                'gallery' => $homepageGallery,
                'type' => $this->mapTypeToName($homepageGallery->getType())
            ];
        }

        return $this->render('KarolineKroissGalleryBundle:Gallery:show.html.twig', $viewData);
    }

    /**
     * @param $type
     * @return string
     */
    private function mapTypeToName($type)
    {
        switch ($type) {
            case 'malerei':
                $name = 'Malerei';
                break;

            case 'druckgrafik':
                $name = 'Druckgrafik';
                break;

            case 'papierarbeiten':
                $name = 'Papierarbeiten';
                break;

            default:
                $name = 'Unbekannte Galerie';
        }

        return $name;
    }

    /**
     * @return \KarolineKroiss\GalleryBundle\Entity\GalleryRepository
     */
    protected function getGalleryRepository()
    {
        return $this->getDoctrine()->getRepository('KarolineKroissGalleryBundle:Gallery');
    }

    /**
     * @return \KarolineKroiss\GalleryBundle\Entity\GalleryImageRepository
     */
    protected function getGalleryImageRepository()
    {
        return $this->getDoctrine()->getRepository('KarolineKroissGalleryBundle:GalleryImage');
    }
}
