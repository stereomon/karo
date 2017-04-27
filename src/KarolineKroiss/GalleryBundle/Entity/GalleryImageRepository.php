<?php

namespace KarolineKroiss\GalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class GalleryImageRepository extends EntityRepository
{

    /**
     * @param \KarolineKroiss\GalleryBundle\Entity\GalleryImage $galleryImage
     *
     * @return void
     */
    public function saveGalleryImage(GalleryImage $galleryImage)
    {
        $this->getEntityManager()->flush($galleryImage);
    }

    /**
     * @param \KarolineKroiss\GalleryBundle\Entity\GalleryImage $galleryImage
     *
     * @return array
     */
    public function findSimilar(GalleryImage $galleryImage)
    {
        return $this->findBy(['galleryImageTheme' => $galleryImage->getGalleryImageTheme()]);
    }

}
