<?php

namespace KarolineKroiss\GalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class GalleryRepository extends EntityRepository
{

    /**
     * @param string $type
     * @return array
     */
    public function findByType($type)
    {
        $queryBuilder = $this->createQueryBuilder('g')
            ->where('g.type = :galleryType')
            ->setParameter('galleryType', $type)
            ->orderBy('g.year', 'DESC')
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param $type
     * @param $year
     * @return \KarolineKroiss\GalleryBundle\Entity\Gallery
     */
    public function findByTypeAndYear($type, $year)
    {
        $queryBuilder = $this->createQueryBuilder('g')
            ->where('g.type = :galleryType')
            ->andWhere('g.year >= :galleryDateStart')
            ->andWhere('g.year <= :galleryDateEnd')
            ->setParameter('galleryType', $type)
            ->setParameter('galleryDateStart', $year)
            ->setParameter('galleryDateEnd', $year)
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @return \KarolineKroiss\GalleryBundle\Entity\Gallery|null
     */
    public function getLatestGallery()
    {
        $queryBuilder = $this->createQueryBuilder('g')
            ->where('g.type = :galleryType')
            ->setParameter('galleryType', 'paintings')
            ->orderBy('g.year', 'DESC')
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param string $type
     *
     * @return array
     */
    public function getYearsByType($type)
    {
        $queryBuilder = $this->createQueryBuilder('g')
            ->where('g.type = :type')
            ->setParameter('type', $type)
            ->groupBy('g.year')
            ->orderBy('g.year', 'DESC')
        ;

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @return \KarolineKroiss\GalleryBundle\Entity\Gallery|null
     */
    public function getHomepageGallery()
    {
        $queryBuilder = $this->createQueryBuilder('g')
            ->where('g.isHomepageGallery = :isHomepageGallery')
            ->setParameter('isHomepageGallery', true)
        ;

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    /**
     * @param \KarolineKroiss\GalleryBundle\Entity\Gallery $gallery
     *
     * @return void
     */
    public function saveGallery(Gallery $gallery)
    {
        $this->getEntityManager()->flush($gallery);
    }

}
