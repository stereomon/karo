<?php

namespace KarolineKroiss\GalleryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Gallery
 *
 * @ORM\Table(name="gallery")
 * @ORM\Entity(repositoryClass="KarolineKroiss\GalleryBundle\Entity\GalleryRepository")
 */
class Gallery
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=128)
     */
    private $type;

    /**
     * @ORM\Column(name="year", type="string", length=4)
     */
    private $year;

    /**
     * This value defines if this particular gallery is shown on the homepage.
     *
     * @ORM\Column(name="isHomePageGallery", type="boolean")
     */
    private $isHomepageGallery = false;

    /**
     * @var GalleryImage
     * @ORM\OneToMany(targetEntity="GalleryImage", mappedBy="gallery", cascade={"all"}, orphanRemoval=true)
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return Gallery
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $year
     *
     * @return Gallery
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return bool
     */
    public function isHomepageGallery()
    {
        return $this->isHomepageGallery;
    }

    /**
     * @param bool $isHomepageGallery
     *
     * @return self
     */
    public function setIsHomepageGallery($isHomepageGallery)
    {
        $this->isHomepageGallery = $isHomepageGallery;

        return $this;
    }

    /**
     * @param GalleryImage $image
     *
     * @return $this
     */
    public function addImage(GalleryImage $image)
    {
        $this->addYearIfNotSet($image);
        $image->setGallery($this);
        $this->images->add($image);

        return $this;
    }

    /**
     * @param GalleryImage $image
     *
     * @return $this
     */
    public function removeImage(GalleryImage $image)
    {
        $this->images->remove($image);

        return $this;
    }

    /**
     * @param ArrayCollection|GalleryImage[] $images
     *
     * @return $this
     */
    public function setImages(ArrayCollection $images)
    {
        foreach ($images as $image) {
            $this->addImage($image);
        }

        return $this;
    }

    /**
     * @return ArrayCollection|GalleryImage[]
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param string $type
     *
     * @return Gallery
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param GalleryImage $image
     */
    protected function addYearIfNotSet(GalleryImage $image)
    {
        if ($image->getYear()) {
            $image->setYear($this->getYear());
        }
    }

}
