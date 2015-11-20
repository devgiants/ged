<?php
/**
 * Created by PhpStorm.
 * User: nicolas
 * Date: 12/11/15
 * Time: 09:16
 */

namespace devgiants\ged\UserBundle\Entity;

use devgiants\ged\DocumentBundle\Entity\Document;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ArrayCollection[devgiants\ged\DocumentBundle\Entity\Document] all documents owned by this user
     * @ORM\OneToMany(targetEntity="devgiants\ged\DocumentBundle\Entity\Document", mappedBy="user", cascade={"persist"})
     */
    private $documents;

    /**
     * @return ArrayCollection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param ArrayCollection $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}