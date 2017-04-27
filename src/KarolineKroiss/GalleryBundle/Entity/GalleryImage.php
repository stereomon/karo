<?php

namespace KarolineKroiss\GalleryBundle\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use PHPImageWorkshop\ImageWorkshop;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DateTime;
/**
 * @ORM\Table(name="gallery_image")
 * @ORM\Entity(repositoryClass="KarolineKroiss\GalleryBundle\Entity\GalleryImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class GalleryImage
{

    const THUMBNAIL_WIDTH = 175;
    const THUMBNAIL_HEIGHT = 120;

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
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="integer", nullable=true)
     */
    private $position;

    /**
    * @var Gallery
     *
    * @ORM\ManyToOne(targetEntity="KarolineKroiss\GalleryBundle\Entity\Gallery", inversedBy="images")
    * @ORM\JoinColumn(name="gallery", referencedColumnName="id", unique=false)
    */
    private $gallery;

    /**
    * @var GalleryImageTheme
     *
    * @ORM\ManyToOne(targetEntity="KarolineKroiss\GalleryBundle\Entity\GalleryImageTheme")
    * @ORM\JoinColumn(name="gallery_image_theme", referencedColumnName="id", unique=false)
    */
    private $galleryImageTheme;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128)
     */
    private $title;

    /**
     * @var \KarolineKroiss\GalleryBundle\Entity\GalleryImageTechnique
     *
     * @ORM\ManyToOne(targetEntity="KarolineKroiss\GalleryBundle\Entity\GalleryImageTechnique")
     * @ORM\JoinColumn(name="gallery_image_technique", referencedColumnName="id", unique=false)
     */
    private $galleryImageTechnique;

    /**
     * @var string
     *
     * @ORM\Column(name="size", type="string", length=64, nullable=true)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=4, nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="saatchi_link", type="string", length=255, nullable=true)
     */
    private $saatchiLink;

    /**
     * @var string
     *
     * @ORM\Column(name="pinterest_link", type="string", length=255, nullable=true)
     */
    private $pinterestLink;

    /**
     * @var
     */
    private $file;

    /**
     * @var string
     */
    private $temp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updated;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_sold", type="boolean")
     */
    private $isSold = false;

    /**
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive = false;

    /**
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     *
     * @return $this
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * @return bool
     */
    public function getIsSold()
    {
        return $this->isSold;
    }

    /**
     * @param bool $isSold
     *
     * @return $this
     */
    public function setIsSold($isSold)
    {
        $this->isSold = $isSold;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $path
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param $position
     * @return $this
     */
    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    /**
     * @param Gallery $gallery
     * @return $this
     */
    public function setGallery(Gallery $gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @return Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param GalleryImageTheme $galleryImageTheme
     *
     * @return $this
     */
    public function setGalleryImageTheme(GalleryImageTheme $galleryImageTheme)
    {
        $this->galleryImageTheme = $galleryImageTheme;

        return $this;
    }

    /**
     * @return \KarolineKroiss\GalleryBundle\Entity\GalleryImageTheme
     */
    public function getGalleryImageTheme()
    {
        return $this->galleryImageTheme;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param GalleryImageTechnique $technique
     *
     * @return $this
     */
    public function setGalleryImageTechnique(GalleryImageTechnique $technique)
    {
        $this->galleryImageTechnique = $technique;

        return $this;
    }

    /**
     * @return GalleryImageTechnique
     */
    public function getGalleryImageTechnique()
    {
        return $this->galleryImageTechnique;
    }

    /**
     * @param string $size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $year
     *
     * @return $this
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
     * @param string $saatchiLink
     *
     * @return $this
     */
    public function setSaatchiLink($saatchiLink)
    {
        $this->saatchiLink = $saatchiLink;

        return $this;
    }

    /**
     * @return string
     */
    public function getSaatchiLink()
    {
        return $this->saatchiLink;
    }

    /**
     * @param string $pinterestLink
     *
     * @return $this
     */
    public function setPinterestLink($pinterestLink)
    {
        $this->pinterestLink = $pinterestLink;

        return $this;
    }

    /**
     * @return string
     */
    public function getPinterestLink()
    {
        return $this->pinterestLink;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        // check if we have an old image path
        if (isset($this->path)) {
            // store the old name to delete after the update
            $this->temp = $this->path;
            $this->path = null;
        } else {
            $this->path = 'initial';
        }
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            $pathParts = pathinfo($this->getFile()->getClientOriginalName());
            $slugify = new Slugify();
            $fileName = $slugify->slugify($pathParts['filename']);

            $this->path = $fileName . '.' . $pathParts['extension'];
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        if (isset($this->temp)) {
            $this->removeUpload();
            $this->temp = null;
        }
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        $this->createPreview();
        $this->createThumbnail();

        $this->setFile(null);
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        unlink($this->getAbsoluteOriginPath());
        unlink($this->getAbsolutePreviewPath());
        unlink($this->getAbsoluteThumbnailPath());
    }

    /**
     * @return string
     */
    public function getAbsoluteOriginPath()
    {
        return $this->getUploadRootDir() . '/' . $this->path;
    }

    /**
     * @return string
     */
    public function getAbsoluteThumbnailPath()
    {
        return $this->getUploadRootDir() . '/thumbnail/' . $this->path;
    }

    /**
     * @return string
     */
    public function getAbsolutePreviewPath()
    {
        return $this->getUploadRootDir() . '/preview/' . $this->path;
    }

    /**
     * @return string
     */
    protected function getUploadRootDir()
    {
        return realpath(__DIR__ . '/../../../../web/gallery/');
    }

    /**
     * @return string
     */
    public function getWebPathOrigin()
    {
        return $this->getWebPathBaseDir() . '/' . $this->path;
    }

    /**
     * @return string
     */
    public function getWebPathPreview()
    {
        return $this->getWebPathBaseDir() . '/preview/' . $this->path;
    }

    /**
     * @return string
     */
    public function getWebPathThumbnail()
    {
        return $this->getWebPathBaseDir() . '/thumbnail/' . $this->path;
    }

    /**
     * @return string
     */
    protected function getWebPathBaseDir()
    {
        return '/gallery';
    }

    /**
     * @param \DateTime $updated
     *
     * @return $this
     */
    public function setUpdated(DateTime $updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @ORM\PostUpdate()
     */
    public function refreshUpdated()
    {
        $this->setUpdated(new DateTime());
    }

    /**
     * @return void
     */
    protected function createPreview()
    {
        $image = ImageWorkshop::initFromPath($this->getAbsoluteOriginPath());
        $image->resizeInPixel(800, null, true);
        $image->save($this->getAbsolutePreviewPath(), true, null, 100);
    }

    /**
     * @return void
     */
    protected function createThumbnail()
    {
        $image = ImageWorkshop::initFromPath($this->getUploadRootDir() . '/' . $this->path);
        $image->resizeInPixel(self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT, true);
        $image->save($this->getAbsoluteThumbnailPath(), true, null, 80);
    }

}
