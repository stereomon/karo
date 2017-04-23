<?php

namespace KarolineKroiss\ExhibitionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Exhibition
 *
 * @ORM\Table(name="exhibition")
 * @ORM\Entity(repositoryClass="KarolineKroiss\ExhibitionBundle\Entity\ExhibitionRepository")
 */
class Exhibition
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
     * @var \DateTime
     *
     * @ORM\Column(name="year", type="datetime")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="gallery", type="string", length=255)
     */
    private $gallery;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $year
     * @return Exhibition
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param string $name
     * @return Exhibition
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
     * @param string $gallery
     * @return Exhibition
     */
    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * @return string
     */
    public function getGallery()
    {
        return $this->gallery;
    }

    /**
     * @param string $link
     * @return Exhibition
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }
}
