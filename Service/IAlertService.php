<?php

namespace Pois\NotificationBundle\Service;

/**
 * Alert service interface
 *
 * @author
 */
interface IAlertService
{
    public function getAllAlerts();
    public function getAlertByName($alertName);
}

