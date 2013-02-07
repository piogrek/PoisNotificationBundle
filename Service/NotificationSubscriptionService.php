<?php

namespace Pois\NotificationBundle\Service;

use Pois\ServiceBundle\Service\ServiceAbstract;

/**
 * Service for interacting with notification subscriptions
 *
 */
class NotificationSubscriptionService extends ServiceAbstract
{

    /**
     * method to retrieve all subscriptions
     *
     * @return ArrayCollection Pois\NotificationBundle\Entity\NotificationSubscription loaded object
     */
    public function getAll($page = 1, $q='')
    {
        $query = $this->em
            ->getRepository($this->entityClass)
            ->findAllQuery($q);

        $pagination = $this->paginator->paginate(
            $query,
            $page                     
        );

        return $pagination;
    }  

    /**
     * [subscribeToNotification description]
     * @param  [type] $notificationId [description]
     * @param  [type] $userId         [description]
     * @return [type]                 [description]
     */
    public function subscribeToNotification($notificationId, $userId) 
    {
        $notification = $this->container->get('g_service.notification')->get($notificationId);
        $user = $this->container->get('g_service.user')->get($userId);

        $subscription = $this->createNew();
        $subscription->setUser($user);
        $subscription->setNotification($notification);
        $this->save($subscription);
    }
    /**
     * [subscribeToNotification description]
     * @param  [type] $notificationId [description]
     * @param  [type] $userId         [description]
     * @return [type]                 [description]
     */
    public function usubscribeFromNotification($notificationId, $userId) 
    {
        $entity = $this->em
                    ->getRepository($this->entityClass)
                    ->findOneByUserAndNotification($notificationId, $userId);
        if ($entity) {
            $this->delete($entity->getId());
            return true;
        } else {
            return false;
        }

    }    

    /**
     * toggle subscription state
     * @param  [type] $notificationId [description]
     * @param  [type] $userId         [description]
     * @return [type]                 true if subscribed, false if unsubscribed
     */
    public function subscribeToNotificationToggle($notificationId, $userId) 
    {
        if (!$this->usubscribeFromNotification($notificationId, $userId)) {
            $this->subscribeToNotification($notificationId, $userId);
            return true;
        } 
        return false;
    }

}

