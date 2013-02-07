<?php
namespace Pois\NotificationBundle\Tests\Service;

require_once(__DIR__ . "../../../../../../app/AppKernel.php");

use Doctrine\ORM\EntityManager,
    Knp\Component\Pager\Paginator,
    Grafix\ServiceBundle\Service\AddressService,
    Pois\NotificationBundle\Entity\Address;

/**
 * Basic phpunit test to test our service.
 *
 */
class NotificationServiceTest extends \PHPUnit_Framework_TestCase
{

    /**
* @var Symfony\Component\HttpKernel\AppKernel
*/
    protected $kernel;

    /**
* @var Doctrine\ORM\EntityManager
*/
    protected $entityManager;

    /**
* @var Symfony\Component\DependencyInjection\Container
*/
    protected $container;

    /**
* @return null
*/
    public function setUp()
    {
        $this->kernel = new \AppKernel('dev', false);
        $this->kernel->boot();

        $this->container = $this->kernel->getContainer();
        $this->entityManager = $this->container->get('doctrine')->getEntityManager();
        parent::setUp();
    }

    /**
    * @return null
    */
    public function tearDown()
    {
        $this->kernel->shutdown();
        parent::tearDown();
    }


    public function testDependencyInjection()
    {
        // act
        $service = $this->container->get('g_service.notification');        
        $this->assertInstanceOf('\Pois\NotificationBundle\Service\NotificationService', $service);

        // act
        $service = $this->container->get('g_service.subscription');        
        $this->assertInstanceOf('\Pois\ServiceBundle\Service\NotificationSubscriptionService', $service);

    }


    /**
    * @return array
    */
    protected function getMetadatas()
    {
        return $this->entityManager->getMetadataFactory()->getAllMetadata();
    }
}

