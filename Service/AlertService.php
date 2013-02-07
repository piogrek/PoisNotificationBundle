<?php

namespace Pois\NotificationBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Alert service - manage all other alert services
 *
 * @author Piotr Grochowski
 */
class AlertService
{
    private $container;
    /**
     * all known services
     * @var [type]
     */
    private $services;

    /**
     * [__construct description]
     * @param ContainerInterface $container [description]
     */
    public function __construct(ContainerInterface $container, Array $services)
    {
        $this->container = $container;
        $this->services = $services;
    }

    /**
     * [getAllAlerts description]
     * @return Array all available alerts
     */
    public function getAllAlertServices()
    {

    }

    /**
     * [getAlertByName description]
     * @param  [type] $alertName [description]
     * @return [type]            [description]
     */
    public function getAlertService($alertName)
    {
        if (in_array($alertName, $this->services)) {
            return $this->container->get('g_service.alert.'.$alertName);
        }

        throw new \Exception("Unknown service '$alertName'", 1);
    } 

    public function checkAllAlertsAndSendNotifications($service)
    {
        $alertSvc = $this->getAlertService($service);
        $alarms = $alertSvc->checkAllAlerts(true);

        // array of notifications user->array of alarms
        $userNotifications = array();
        if (count($alarms)) {

            //iterate all alarms
            foreach ($alarms as $alarm) {

                //get all subscriptions to notification
                foreach($alarm['notification']->getSubscriptions() as $subscription) {
                    $user = $subscription->getUser();
                    if (!isset($userNotifications[$user->getId()])) {
                        $userNotifications[$user->getId()] = array(
                            'alarms' => array(),
                            'user'   => $user
                            );
                    }

                    $userNotifications[$user->getId()]['alarms'][] = $alarm;
                }
            }

            //render one email per user
            foreach ($userNotifications as  $userAlarms) {
                $user = $userAlarms['user'];
                $html = $this->container->get('templating')->render(
                    'PoisNotificationBundle:EmailTemplates:email_alert_user_cron.html.twig',
                    array(
                        'date' => new \DateTime('now'),
                        'userAlarms' => $userAlarms['alarms']
                    )
                );
  
                $message = \Swift_Message::newInstance()
                    ->setSubject('Powiadomienia z dnia ' . date('Y-m-d'))
                    ->setFrom('piogrek@gmail.com')
                    ->setTo($user->getEmail())
                    ->setBody($html, 'text/html')
                ;
                $this->container->get('mailer')->send($message);
            }
        }
    }
}
