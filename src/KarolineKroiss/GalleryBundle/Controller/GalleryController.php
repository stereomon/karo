<?php

namespace KarolineKroiss\GalleryBundle\Controller;

use KarolineKroiss\GalleryBundle\Entity\Gallery;
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
        $galleries = $this->getGalleryRepository()->findByTypeAndYear($type, $year);
        $images = $this->getImages($galleries);

        return $this->render('KarolineKroissGalleryBundle:Gallery:show.html.twig', [
            'images' => $images,
            'type' => $this->mapTypeToName($type),
            'similarImages' => false
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showSimilarAction($id)
    {
        $image = $this->getGalleryImageRepository()->findOneBy(['id' => $id]);
        $images = $this->getGalleryImageRepository()->findBy(['galleryImageTheme' => $image->getGalleryImageTheme()->getId()]);

        return $this->render('KarolineKroissGalleryBundle:Gallery:show.html.twig', [
            'images' => $images,
            'type' => $this->mapTypeToName($image->getGalleryImageTheme()->getName()),
            'similarImages' => true
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function firstGalleryAction()
    {
        $homepageGallery = $this->getGalleryRepository()->getHomepageGallery();

        return $this->render('KarolineKroissGalleryBundle:Gallery:show.html.twig', [
            'gallery' => $homepageGallery,
            'type' => $this->mapTypeToName($homepageGallery->getType())
        ]);
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailImageAction($id)
    {
        $image = $this->getGalleryImageRepository()->findOneBy(['id' => $id]);
        $similar = $this->getGalleryImageRepository()->findBy([
            'galleryImageTheme' => $image->getGalleryImageTheme()
        ]);

        return $this->render('KarolineKroissGalleryBundle:Gallery:detail.html.twig', ['similar' => $similar]);
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
     * @param Gallery[] $galleries
     *
     * @return array
     */
    private function getImages($galleries)
    {
        $images = [];
        foreach ($galleries as $gallery) {
            foreach ($gallery->getImages() as $image) {
                $images[] = $image;
            }
        }

        return $images;
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
