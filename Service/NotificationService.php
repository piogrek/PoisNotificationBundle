<?php

namespace Pois\NotificationBundle\Service;

use Pois\ServiceBundle\Service\ServiceAbstract;

/**
 * Service for interacting with notifications
 *
 */
class NotificationService extends ServiceAbstract
{


    /**
     * method to retrieve all messages
     *
     * @return ArrayCollection Pois\NotificationBundle\Entity\Notification loaded object
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
     * retrieve notification for artykul object
     */
    public function getAllForService($serviceName)
    {
        $entities = $this->em
                    ->getRepository($this->entityClass)
                    ->findByService($serviceName);

        if (!$entities) {
            throw new \Exception('Nie znaleziono powiadomien');
        }

        return $entities;
    }

}

