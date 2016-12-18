<?php

namespace Dreimweb\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Dreimweb\UserBundle\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 */
class User implements AdvancedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;


    /**
     * @var string
     *
     * @ORM\Column(name="flagstate", type="string", length=255, nullable=true)
     */
    private $flagstate = 0;


    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     */
    private $gender = "m";


    /**
     * @var string
     *
     * @ORM\Column(name="attributes", type="text", nullable=true)
     */
    private $attributes;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="ident_key", type="string", length=75)
	 */
	private $ident_key = "";


	/**
	 * @var bool
	 *
	 * @ORM\Column(type="boolean")
	 */
	private $isActive = false;



	/**
     * @ORM\Column(type="json_array")
     */
    private $roles = array();


    /** @ORM\Column(name="created_at", type="string", length=255) */
    private $createdAt;


    /** @ORM\Column(name="updated_at", type="string", length=255) */
    private $updatedAt;


	public function isAccountNonExpired()
	{
		return true;
	}

	public function isAccountNonLocked()
	{
		return $this->getIsActive();
	}

	public function isCredentialsNonExpired()
	{
		return true;
	}

	public function isEnabled()
	{
		return $this->getIsActive();
	}


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->updatedAt = date('Y-m-d H:i:s');
    }


    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->createdAt = date('Y-m-d H:i:s');
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        // allows for chaining
        return $this;
    }


    public function eraseCredentials()
    {
        // blank for now
    }


    public function getSalt()
    {
        return null;
    }


    /**
     * generate random string
     *
     * @param int $length
     * @return string
     */
    public static function generatePassword($length = 8)
    {
        $possibleChars = "abcdefghijklmnopqrstuvwxyz0123456789*!+";
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $rand = rand(0, strlen($possibleChars) - 1);
            $password .= substr($possibleChars, $rand, 1);
        }

        return $password;
    }

    /**
     * @return string
     */
    public function getFlagstate()
    {
        return $this->flagstate;
    }

    /**
     * @param string $flagstate
     */
    public function setFlagstate($flagstate)
    {
        $this->flagstate = $flagstate;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }


	/**
	 * @return mixed
	 */
	public function getIdentKey()
	{
		return $this->ident_key;
	}

	/**
	 * @param mixed $ident_key
	 */
	public function setIdentKey($ident_key)
	{
		$this->ident_key = $ident_key;
	}

	/**
	 * @return mixed
	 */
	public function getIsActive()
	{
		return $this->isActive;
	}

	/**
	 * @param mixed $isActive
	 */
	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
	}

}

