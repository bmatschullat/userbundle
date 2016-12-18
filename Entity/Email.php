<?php

namespace Dreimweb\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Sensor
 *
 * @ORM\Table(name="email")
 * @ORM\Entity(repositoryClass="Dreimweb\UserBundle\Repository\EmailRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Email
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
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="receiver", type="string", length=255)
     */
    private $receiver;

    /**
     * @var string
     *
     * @ORM\Column(name="flagstate", type="string", length=255, nullable=true)
     */
    private $flagstate = 0;


    /**
     * @var string
     *
     * @ORM\Column(name="body_message", type="text")
     */
    private $bodyMessage;

    /** @ORM\Column(name="created_at", type="string", length=255) */
    private $createdAt;


    /** @ORM\Column(name="updated_at", type="string", length=255) */
    private $updatedAt;

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
        $this->updatedAt = date('Y-m-d H:i:s');
        $this->createdAt = date('Y-m-d H:i:s');
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
     * Set subject
     *
     * @param string $subject
     *
     * @return Email
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }



    /**
     * Set bodyMessage
     *
     * @param string $bodyMessage
     *
     * @return Email
     */
    public function setBodyMessage($bodyMessage)
    {
        $this->bodyMessage = $bodyMessage;

        return $this;
    }

    /**
     * Get bodyMessage
     *
     * @return string
     */
    public function getBodyMessage()
    {
        return $this->bodyMessage;
    }

    /**
     * @return string
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param string $receiver
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
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




}

