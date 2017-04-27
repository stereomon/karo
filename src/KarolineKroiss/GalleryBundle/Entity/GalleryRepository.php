<?php

namespace KarolineKroiss\GalleryBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class GalleryRepository extends EntityRepository
{

    /**
     * @param string $type
     * @return array
     */
    public function findByType($type)
    {
        $queryBuilder = $this->createQueryBuilder('g')
            ->addSelect('i')
            ->where('g.type = :galleryType')
            ->where('g.isActive = :isActive')
            ->leftJoin('g.images', 'i', 'WITH', 'i.isActive = :isActive')
            ->setParameter('galleryType', $type)
            ->setParameter('isActive', true)
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
            ->addSelect('i')
            ->where('g.type = :galleryType')
            ->andWhere('g.isActive = :isActive')
            ->andWhere('g.year >= :galleryDateStart')
            ->andWhere('g.year <= :galleryDateEnd')
            ->leftJoin('g.images', 'i', 'WITH', 'i.isActive = :isActive')
            ->setParameter('galleryType', $type)
            ->setParameter('isActive', true)
            ->setParameter('galleryDateStart', $year)
            ->setParameter('galleryDateEnd', $year)
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
            ->andWhere('g.isActive = :isActive')
            ->setParameter('isActive', true)
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
            ->addSelect('i')
            ->where('g.isHomepageGallery = :isHomepageGallery')
            ->leftJoin('g.images', 'i', 'WITH', 'i.isActive = :isActive')
            ->setParameter('isActive', true)
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
