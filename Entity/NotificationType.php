<?php

namespace Pois\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Pois\ServiceBundle\Entity\EntityInterface;

/**
 * NotificationType
 *
 * @ORM\Table(name="g_notification_type")
 * @ORM\Entity
 */
class NotificationType implements EntityInterface
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="service", type="string", length=255)
     */
    private $service;

    /**
     * @var string
     *
     * @ORM\Column(name="template", type="text")
     */
    private $template;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isCron", type="boolean")
     */
    private $isCron;

    /**
     * @var integer
     *
     * @ORM\Column(name="delay", type="integer")
     */
    private $delay;


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
     * @return NotificationType
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
     * Set template
     *
     * @param string $template
     * @return NotificationType
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    
        return $this;
    }

    /**
     * Get template
     *
     * @return string 
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * Set isCron
     *
     * @param boolean $isCron
     * @return NotificationType
     */
    public function setIsCron($isCron)
    {
        $this->isCron = $isCron;
    
        return $this;
    }

    /**
     * Get isCron
     *
     * @return boolean 
     */
    public function getIsCron()
    {
        return $this->isCron;
    }

    /**
     * Set delay
     *
     * @param integer $delay
     * @return NotificationType
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;
    
        return $this;
    }

    /**
     * Get delay
     *
     * @return integer 
     */
    public function getDelay()
    {
        return $this->delay;
    }


    /**
     * @return Array
     */
    public function toArray()
    {
        return array();
    }     

    /**
     * Set service
     *
     * @param string $service
     * @return NotificationType
     */
    public function setService($service)
    {
        $this->service = $service;
    
        return $this;
    }

    /**
     * Get service
     *
     * @return string 
     */
    public function getService()
    {
        return $this->service;
    }
}