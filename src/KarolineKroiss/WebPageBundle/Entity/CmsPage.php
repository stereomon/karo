<?php

namespace KarolineKroiss\WebPageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CmsPage
 *
 * @ORM\Table(name="cms_page")
 * @ORM\Entity(repositoryClass="KarolineKroiss\WebPageBundle\Entity\CmsPageRepository")
 */
class CmsPage
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
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     * @ORM\Column(name="content_formatter", type="string")
     */
    private $contentFormatter;

    /**
     * @var string
     * @ORM\Column(name="raw_content", type="text")
     */
    private $rawContent;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return CmsPage
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
     * @param string $content
     * @return CmsPage
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $contentFormatter
     * @return CmsPage
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
        return $this;
    }

    /**
     * @return string
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * @param string $rawContent
     * @return CmsPage
     */
    public function setRawContent($rawContent)
    {
        $this->rawContent = $rawContent;
        return $this;
    }

    /**
     * @return string
     */
    public function getRawContent()
    {
        return $this->rawContent;
    }

    /**
     * @param \DateTime $date
     * @return CmsPage
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }
}
