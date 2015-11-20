<?php

namespace devgiants\ged\DocumentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * File
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class File
{
    /**
     * @var integer the internal File ID
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string the relative URL to file
     *
     * @ORM\Column(name="urlToFile", type="string", length=255)
     */
    private $urlToFile;

    /**
     * @var string the relative URL to file thumbnail
     *
     * @ORM\Column(name="urlToThumbnail", type="string", length=255)
     */
    private $urlToThumbnail;

    /**
     * @var Document the document linked to this file
     *
     * @ORM\ManyToOne(targetEntity="Document", inversedBy="files", cascade={"persist"})
     */
    private $document;


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
     * Set pathToFile
     *
     * @param string $urlToFile
     *
     * @return File
     */
    public function setUrlToFile($urlToFile)
    {
        $this->urlToFile = $urlToFile;

        return $this;
    }

    /**
     * Get pathToFile
     *
     * @return string
     */
    public function getUrlToFile()
    {
        return $this->urlToFile;
    }

    /**
     * Set pathToThumbnail
     *
     * @param string $urlToThumbnail
     *
     * @return File
     */
    public function setUrlToThumbnail($urlToThumbnail)
    {
        $this->urlToThumbnail = $urlToThumbnail;

        return $this;
    }

    /**
     * Get pathToThumbnail
     *
     * @return string
     */
    public function getUrlToThumbnail()
    {
        return $this->urlToThumbnail;
    }

    /**
     * Set document
     *
     * @param \devgiants\ged\DocumentBundle\Entity\Document $document
     *
     * @return File
     */
    public function setDocument(\devgiants\ged\DocumentBundle\Entity\Document $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \devgiants\ged\DocumentBundle\Entity\Document
     */
    public function getDocument()
    {
        return $this->document;
    }
}
