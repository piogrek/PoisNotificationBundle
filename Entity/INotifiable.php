<?php

namespace Pois\NotificationBundle\Entity;

/**
 * interface of notifiable object
 * @author peterg
 */
interface INotifiable
{
    /**
     * ORM\ManyToMany(targetEntity="\Pois\NotificationBundle\Entity\Notification", cascade={"remove"})
     */
    // protected $notifications;
    public function addNotification(\Pois\NotificationBundle\Entity\Notification $notifications);
    public function removeNotification(\Pois\NotificationBundle\Entity\Notification $notifications);
    public function getNotifications();

}
