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
     * @param string $name
     *
     * @return object|\KarolineKroiss\GalleryBundle\Entity\GalleryImage
     */
    public function findByName($name)
    {
        return $this->findOneBy(['name' => $name]);
    }

}
