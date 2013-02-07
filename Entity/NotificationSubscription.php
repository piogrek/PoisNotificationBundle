<?php

namespace Pois\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pois\CommentBundle\Entity\ICommentable;
use Pois\ServiceBundle\Entity\EntityInterface;

/**
 * NotificationSubscription
 * subscription can be connected only to one notification
 *
 * @ORM\Table(name="g_notification_subscription")
 * @ORM\Entity(repositoryClass="Pois\NotificationBundle\Entity\NotificationSubscriptionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class NotificationSubscription implements ICommentable, EntityInterface
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
     * @var array
     *
     * @ORM\Column(name="parameters", type="json_array", nullable=true)
     */
    private $parameters;

    /***************************************************************************
     * Relations
     **************************************************************************/

    /**
     * Notification
     *
     * @ORM\ManyToOne(targetEntity="Notification", inversedBy="subscriptions", cascade={"persist"})
     */
    private $notification;

    /**
     * @ORM\ManyToMany(targetEntity="\Pois\CommentBundle\Entity\Message", cascade={ "persist", "remove"})
     * @ORM\OrderBy({"created" = "DESC", "id" = "DESC"})
     */
    private $messages;


    /**
     * @ORM\ManyToOne(targetEntity="\Grafix\UserBundle\Entity\User", cascade={"persist"})
     */
    private $user;
    
    /***************************************************************************
     * Lifecycle
     **************************************************************************/


    /**
     * Timestamp for the last date this object was updated
     *
     * @var datetime $updated
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * Timestamp for the objects creation
     *
     * @var datetime $created
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;


    /**
     * Set the created value to now.
     *
     * @author peterg
     *
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
        $this->created = new \DateTime();
    }

    /**
     * Set the update value to now.
     *
     * @author peterg
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->updated = new \DateTime();
    }     

    
    /***************************************************************************
     * getters and setters
     **************************************************************************/

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
     * Set parameters
     *
     * @param array $parameters
     * @return NotificationSubscription
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    
        return $this;
    }

    /**
     * Get parameters
     *
     * @return array 
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return NotificationSubscription
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return NotificationSubscription
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }


    /**
     * Add messages
     *
     * @param Pois\CommentBundle\Entity\Message $messages
     * @return MgDokument
     */
    public function addMessage(\Pois\CommentBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;

        return $this;
    }

    /**
     * Remove messages
     *
     * @param Pois\CommentBundle\Entity\Message $messages
     */
    public function removeMessage(\Pois\CommentBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Set notification
     *
     * @param \Pois\NotificationBundle\Entity\Notification $notification
     * @return NotificationSubscription
     */
    public function setNotification(\Pois\NotificationBundle\Entity\Notification $notification = null)
    {
        $this->notification = $notification;
    
        return $this;
    }

    /**
     * Get notification
     *
     * @return \Pois\NotificationBundle\Entity\Notification 
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Set user
     *
     * @param \Grafix\UserBundle\Entity\User $user
     * @return NotificationSubscription
     */
    public function setUser(\Grafix\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Grafix\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * @return Array
     */
    public function toArray()
    {
        return array();
    }     
}
