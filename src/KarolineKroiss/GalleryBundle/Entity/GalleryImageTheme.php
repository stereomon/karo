<?php

namespace KarolineKroiss\GalleryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="gallery_image_theme")
 * @ORM\Entity(repositoryClass="KarolineKroiss\GalleryBundle\Entity\GalleryImageThemeRepository")
 */
class GalleryImageTheme
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=128)
     *
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection|\KarolineKroiss\GalleryBundle\Entity\GalleryImage[]
     *
     * @ORM\ManyToMany(targetEntity="GalleryImage", mappedBy="galleryImageThemes", fetch="EAGER")
     */
    private $galleryImages;

    public function __construct()
    {
        $this->galleryImages = new ArrayCollection();
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return $this
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
     * @return \Doctrine\Common\Collections\Collection|\KarolineKroiss\GalleryBundle\Entity\GalleryImage[]
     */
    public function getGalleryImages()
    {
        return $this->galleryImages;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $galleryImages
     *
     * @return $this
     */
    public function setGalleryImages(ArrayCollection $galleryImages)
    {
        $this->galleryImages = $galleryImages;

        return $this;
    }

    /**
     * @param \KarolineKroiss\GalleryBundle\Entity\GalleryImage $image
     *
     * @return $this
     */
    public function addGalleryImage(GalleryImage $image)
    {
        if (!$this->galleryImages->contains($image)) {
            $image->addGalleryImageTheme($this);
            $this->galleryImages->add($image);
        }


        return $this;
    }

    /**
     * @param \KarolineKroiss\GalleryBundle\Entity\GalleryImage $image
     *
     * @return $this
     */
    public function removeGalleryImage(GalleryImage $image)
    {
        if ($this->galleryImages->contains($image)) {
            $image->removeGalleryImageTheme($this);
            $this->galleryImages->remove($image);
        }


        return $this;
    }


}
