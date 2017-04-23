<?php

namespace KarolineKroiss\GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PHPImageWorkshop\ImageWorkshop;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * GalleryImage
 *
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
    * @ORM\ManyToOne(targetEntity="KarolineKroiss\GalleryBundle\Entity\Gallery", inversedBy="images")
    * @ORM\JoinColumn(name="gallery", referencedColumnName="id", unique=false)
    */
    private $gallery;

    /**
    * @var GalleryImageTheme
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
     * @var string
     *
     * @ORM\Column(name="technic", type="string", length=64, nullable=true)
     */
    private $technic;

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
     * Set title
     *
     * @param string $title
     * @return Gallery
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set technic
     *
     * @param string $technic
     * @return Gallery
     */
    public function setTechnic($technic)
    {
        $this->technic = $technic;

        return $this;
    }

    /**
     * Get technic
     *
     * @return string
     */
    public function getTechnic()
    {
        return $this->technic;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return Gallery
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set year
     *
     * @param string $year
     * @return Gallery
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param $saatchiLink
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
     * @param $pinterestLink
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
            $fileBaseName = str_replace($this->getFile()->getClientOriginalExtension(), '', $this->getFile()->getClientOriginalName());
            $this->path = $this->getFile()->getClientOriginalName();
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
    public function storeFilenameForRemove()
    {
        $this->temp = $this->getAbsolutePath();
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        $name = $this->path;
        unlink($this->getUploadRootDir() . '/' . $name);
        unlink($this->getUploadRootDir() . '/preview/' . $name);
        unlink($this->getUploadRootDir() . '/thumbnail/' . $name);
    }

    /**
     * @return null|string
     */
    public function getAbsolutePath()
    {
        return $this->getUploadRootDir() . '/' . $this->path;
    }

    /**
     * @return string
     */
    protected function buildFileName()
    {
        return $this->getId() . '.' . $this->getPath();
    }

    /**
     * @return null|string
     */
    public function getWebPath()
    {
        return $this->getUploadDir() . '/' . $this->path;
    }

    /**
     * @return string
     */
    public function getPreviewPath()
    {
        return $this->getUploadDir() . '/preview/' . $this->path;
    }

    /**
     * @return string
     */
    public function getThumbnailPath()
    {
        return $this->getUploadDir() . '/thumbnail/' . $this->path;
    }

    /**
     * @return string
     */
    public function getUploadRootDir()
    {
        return __DIR__ . '/../../../../web/' . $this->getUploadDir();
    }

    /**
     * @return string
     */
    protected function getUploadDir()
    {
        return '/gallery/' . $this->getGallery()->getId();
    }

    /**
     * @param \DateTime $updated
     * @return GalleryImage
     */
    public function setUpdated(\DateTime $updated)
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
        $this->setUpdated(new \DateTime());
    }

    protected function createPreview()
    {
        $image = ImageWorkshop::initFromPath($this->getUploadRootDir() . '/' . $this->path);
        $image->resizeInPixel(800, null, true);
        $image->save($this->getUploadRootDir() . '/preview/', $this->path, true, null, 100);
    }

    protected function createThumbnail()
    {
        $image = ImageWorkshop::initFromPath($this->getUploadRootDir() . '/' . $this->path);
        $image->resizeInPixel(self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT, true);
        $image->save($this->getUploadRootDir() . '/thumbnail/', $this->path, true, null, 80);
    }
}
