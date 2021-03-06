<?php

namespace KarolineKroiss\GalleryBundle\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PHPImageWorkshop\ImageWorkshop;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @var Collection|GalleryImageTheme[]
     *
     * @ORM\ManyToMany(targetEntity="GalleryImageTheme", inversedBy="galleryImages", fetch="EAGER")
     * @ORM\JoinTable(name="gallery_image_themes",
     *      joinColumns={@ORM\JoinColumn(name="gallery_image_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="gallery_image_theme_id", referencedColumnName="id")}
     *      )
     */
    private $galleryImageThemes;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     */
    private $oldTitle;

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
     * Store old file name if new one is added. This is then
     * used to delete the old image after the new one is applied.
     *
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

    public function __construct()
    {
        $this->galleryImageThemes = new ArrayCollection();
    }

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
     * @param Collection|GalleryImageTheme[] $galleryImageThemes
     *
     * @return $this
     */
    public function setGalleryImageThemes(Collection $galleryImageThemes)
    {
        $this->galleryImageThemes = $galleryImageThemes;

        return $this;
    }

    /**
     * @param GalleryImageTheme $galleryImageTheme
     *
     * @return $this
     */
    public function addGalleryImageTheme(GalleryImageTheme $galleryImageTheme)
    {
        if (!$this->galleryImageThemes->contains($galleryImageTheme)) {
            $galleryImageTheme->addGalleryImage($this);
            $this->galleryImageThemes->add($galleryImageTheme);
        }

        return $this;
    }

    /**
     * @param GalleryImageTheme $galleryImageTheme
     *
     * @return $this
     */
    public function removeGalleryImageTheme(GalleryImageTheme $galleryImageTheme)
    {
        if ($this->galleryImageThemes->contains($galleryImageTheme)) {
            $galleryImageTheme->removeGalleryImage($this);
            $this->galleryImageThemes->add($galleryImageTheme);
        }

        return $this;
    }

    /**
     * @return Collection|\KarolineKroiss\GalleryBundle\Entity\GalleryImageTheme[]
     */
    public function getGalleryImageThemes()
    {
        return $this->galleryImageThemes;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->oldTitle = $this->title;
        $this->title = $title;
        $this->setName($title);

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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public function setName($name)
    {
        $this->name = $this->slugify($name);

        return $this;
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
            $fileName = $this->slugify($this->title);

            $this->path = $fileName . '.' . strtolower($pathParts['extension']);
        }
    }

    /**
     * @ORM\PreUpdate()
     *
     * @return void
     */
    public function updateImageNames()
    {
        if ($this->oldTitle && $this->title !== $this->oldTitle && $this->path) {
            $oldImageName = $this->slugify($this->oldTitle);
            $newImageName = $this->slugify($this->title);
            $oldFilePaths = $this->getFilePaths();
            $this->path = str_replace($oldImageName, $newImageName, $this->path);
            $newFilePaths = $this->getFilePaths();

            $filesystem = new Filesystem();
            foreach ($oldFilePaths as $index => $filePath) {
                if (is_file($filePath)) {
                    $filesystem->rename($filePath, $newFilePaths[$index]);
                }
            }
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

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->path
        );

        $this->createPreview();
        $this->createThumbnail();

        $this->setFile(null);

        if (isset($this->temp) && is_file($this->temp)) {
            unlink($this->temp);
        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function removeUpload()
    {
        $fileList = $this->getFilePaths();

        foreach ($fileList as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }
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
        $path = $this->getAbsolutePreviewPath();
        $image->save(dirname($path), basename($path), true, null, 100);
    }

    /**
     * @return void
     */
    protected function createThumbnail()
    {
        $image = ImageWorkshop::initFromPath($this->getUploadRootDir() . '/' . $this->path);
        $image->resizeInPixel(self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT, true);
        $path = $this->getAbsoluteThumbnailPath();
        $image->save(dirname($path), basename($path), true, null, 80);
    }

    /**
     * @param $title
     *
     * @return string
     */
    private function slugify($title)
    {
        $slugify = new Slugify();

        return $slugify->slugify($title);
    }

    /**
     * @return array
     */
    private function getFilePaths()
    {
        $fileList = [
            $this->getAbsoluteOriginPath(),
            $this->getAbsolutePreviewPath(),
            $this->getAbsoluteThumbnailPath(),
        ];

        return $fileList;
    }

    /**
     * @return true
     */
    public function hasSimilarImages()
    {
        foreach ($this->getGalleryImageThemes() as $galleryImageTheme) {
            foreach ($galleryImageTheme->getGalleryImages() as $galleryImage) {
                if ($galleryImage->getId() !== $this->getId()) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function getSimilarImages()
    {
        $similarImages = [
            $this->getId() => $this,
        ];

        foreach ($this->getGalleryImageThemes() as $galleryImageTheme) {
            foreach ($galleryImageTheme->getGalleryImages() as $galleryImage) {
                if ($galleryImage->getIsActive() && !isset($similarImages[$galleryImage->getId()]) && $galleryImage->getId() !== $this->getId()) {
                    $similarImages[$galleryImage->getId()] = $galleryImage;
                }
            }
        }

        return $similarImages;
    }

}
