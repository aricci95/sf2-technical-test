<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $firstName = '';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lastName = '';

    /**
     * Gets the value of firstName.
     *
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Sets the value of firstName.
     *
     * @param mixed $firstName the first name
     *
     * @return self
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Gets the value of lasttName.
     *
     * @return mixed
     */
    public function getLasttName()
    {
        return $this->lasttName;
    }

    /**
     * Sets the value of lasttName.
     *
     * @param mixed $lasttName the lastt name
     *
     * @return self
     */
    public function setLasttName($lasttName)
    {
        $this->lasttName = $lasttName;

        return $this;
    }
}
