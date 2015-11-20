<?php

namespace devgiants\ged\DocumentBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Document
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="devgiants\ged\DocumentBundle\Entity\DocumentRepository")
 */
class Document
{
    /**
     * @var integer the internal ID, but represents also the number provided by the system to retrieve file on paper storage
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string the document name/title
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string the document description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * var ArrayCollection[File] all media files linked to this document
     * @ORM\OneToMany(targetEntity="File", mappedBy="document", cascade={"persist"})
     */
    private $files;

    /**
     * @var ArrayCollection[Tag] all tags linked to this document
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="document", cascade={"persist"})
     */
    private $tags;


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
     * Set name
     *
     * @param string $name
     *
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Document
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    /**
     * Add file
     *
     * @param \devgiants\ged\DocumentBundle\Entity\File $file
     *
     * @return Document
     */
    public function addFile(File $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \devgiants\ged\DocumentBundle\Entity\File $file
     */
    public function removeFile(File $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

}
