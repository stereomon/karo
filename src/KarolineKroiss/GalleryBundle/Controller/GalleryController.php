<?php

namespace KarolineKroiss\GalleryBundle\Controller;

use Cocur\Slugify\Slugify;
use KarolineKroiss\GalleryBundle\Entity\Gallery;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GalleryController extends Controller
{

    /**
     * @return void
     */
    public function refactorAction()
    {
        $repo = $this->getGalleryImageRepository();

        /* @var $galleryImage \KarolineKroiss\GalleryBundle\Entity\GalleryImage */
        foreach ($repo->findAll() as $galleryImage) {
            $pathParts = pathinfo($galleryImage->getPath());
            $slugify = new Slugify();
            $fileName = $slugify->slugify($pathParts['filename']);
            $newFileName = $fileName . '.' . strtolower($pathParts['extension']);
            $galleryImage->setPath($newFileName);
            $repo->saveGalleryImage($galleryImage);
        }
    }

    /**
     * @param string $type
     * @param int $year
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showByTypeAndYearAction($type, $year)
    {
        $gallery = $this->getGalleryRepository()->findByTypeAndYear($type, $year);

        return $this->render('KarolineKroissGalleryBundle:Gallery:show.html.twig', [
            'gallery' => $gallery,
            'type' => $this->mapTypeToName($gallery->getType()),
            'similarImages' => false
        ]);
    }

    /**
     * @param string $path
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showSimilarAction($path)
    {
        $galleryImage = $this->getGalleryImageRepository()->findOneBy(['path' => $path]);
        $similarImages = $this->getGalleryImageRepository()->findSimilar($galleryImage);

        return $this->render('KarolineKroissGalleryBundle:Gallery:show.html.twig', [
            'images' => $similarImages,
            'type' => $this->mapTypeToName($galleryImage->getGalleryImageTheme()->getName()),
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
        $galleryImage = $this->getGalleryImageRepository()->findOneBy(['id' => $id]);
        $similar = $this->getGalleryImageRepository()->findBy([
            'galleryImageTheme' => $galleryImage->getGalleryImageTheme()
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
