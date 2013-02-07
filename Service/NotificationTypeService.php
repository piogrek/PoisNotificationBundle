<?php

namespace Pois\NotificationBundle\Service;

use Pois\ServiceBundle\Service\ServiceAbstract;

/**
 * Service for interacting with notification types
 *
 */
class NotificationTypeService extends ServiceAbstract
{
    /**
     * retrieve notification type for artykul object
     */
    public function getAllForArtykul()
    {
        $entity = $this->em
                    ->getRepository($this->entityClass)
                    ->findById(array(1,2));

        if (!$entity) {
            throw new \Exception('Nie znaleziono powiadomien');
        }

        return $entity;
    }
}
