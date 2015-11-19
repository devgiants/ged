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
     * @ORM\Column(name="pathToFile", type="string", length=255)
     */
    private $pathToFile;

    /**
     * @var string
     *
     * @ORM\Column(name="pathToThumbnail", type="string", length=255)
     */
    private $pathToThumbnail;

    /**
     * @var Document
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
     * @param string $pathToFile
     *
     * @return File
     */
    public function setPathToFile($pathToFile)
    {
        $this->pathToFile = $pathToFile;

        return $this;
    }

    /**
     * Get pathToFile
     *
     * @return string
     */
    public function getPathToFile()
    {
        return $this->pathToFile;
    }

    /**
     * Set pathToThumbnail
     *
     * @param string $pathToThumbnail
     *
     * @return File
     */
    public function setPathToThumbnail($pathToThumbnail)
    {
        $this->pathToThumbnail = $pathToThumbnail;

        return $this;
    }

    /**
     * Get pathToThumbnail
     *
     * @return string
     */
    public function getPathToThumbnail()
    {
        return $this->pathToThumbnail;
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
