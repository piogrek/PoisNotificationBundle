<?php

namespace Pois\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pois\ServiceBundle\Entity\EntityInterface;

/**
 * Notification
 *
 * @ORM\Table(name="g_notification")
 * @ORM\Entity(repositoryClass="Pois\NotificationBundle\Entity\NotificationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Notification implements EntityInterface
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
     * @ORM\Column(name="parameters", type="json_array")
     */
    private $parameters;
    
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
     * Relations
     **************************************************************************/

    /**
     * Notification Type
     *
     * @ORM\ManyToOne(targetEntity="NotificationType", cascade={"persist"})
     */
    private $notificationType;

    /**
     * @ORM\OneToMany(targetEntity="NotificationSubscription", mappedBy="notification", cascade={"persist"})
     */
    private $subscriptions;

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
     * Set updated
     *
     * @param \DateTime $updated
     * @return Notification
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
     * @return Notification
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
     * Set notificationType
     *
     * @param \Pois\NotificationBundle\Entity\NotificationType $notificationType
     * @return Notification
     */
    public function setNotificationType(\Pois\NotificationBundle\Entity\NotificationType $notificationType = null)
    {
        $this->notificationType = $notificationType;
    
        return $this;
    }

    /**
     * Get notificationType
     *
     * @return \Pois\NotificationBundle\Entity\NotificationType 
     */
    public function getNotificationType()
    {
        return $this->notificationType;
    }

    /**
     * Set parameters
     *
     * @param array $parameters
     * @return Notification
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
     * @return Array
     */
    public function toArray()
    {
        return array();
    }     
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->subscription = new \Doctrine\Common\Collections\ArrayCollection();
    }
    


    /**
     * Add subscriptions
     *
     * @param \Pois\NotificationBundle\Entity\NotificationSubscription $subscriptions
     * @return Notification
     */
    public function addSubscription(\Pois\NotificationBundle\Entity\NotificationSubscription $subscriptions)
    {
        $this->subscriptions[] = $subscriptions;
    
        return $this;
    }

    /**
     * Remove subscriptions
     *
     * @param \Pois\NotificationBundle\Entity\NotificationSubscription $subscriptions
     */
    public function removeSubscription(\Pois\NotificationBundle\Entity\NotificationSubscription $subscriptions)
    {
        $this->subscriptions->removeElement($subscriptions);
    }

    /**
     * Get subscriptions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }
}
