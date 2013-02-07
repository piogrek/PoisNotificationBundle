<?php
namespace Pois\NotificationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckAlertsCommand extends ContainerAwareCommand {

    protected function configure()
    {
        $this
            ->setName('grafix:check-alerts')
            ->setDescription('Check system alerts')
            ->addArgument(
                'service',
                InputArgument::OPTIONAL,
                'Which service to check?'
            );            
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = $input->getArgument('service');
        if ($service) {
            $service = 'Hello '.$service;
        } else {
            $service = 'Hello';
        }

        $this->getContainer()->get('g_service.alert')->checkAllAlertsAndSendNotifications('magazyn');
    }

}
