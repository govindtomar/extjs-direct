<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 23.07.15
 * Time: 11:20
 */

namespace GT\ExtDirect\Tests\Service;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use GT\ExtDirect\Metadata\Driver\AnnotationDriver;
use GT\ExtDirect\Service\ContainerServiceFactory;

/**
 * Class ContainerServiceFactoryTest
 *
 * @package GT\ExtDirect\Tests\Service
 */
class ContainerServiceFactoryTest extends TestCase
{

    public function testServiceFactoryWithServiceId()
    {
        $classMetadata = $this->loadMetadataForClass('GT\ExtDirect\Tests\Service\Services\Service1');
        $container = $this->createContainer();

        $service = new \GT\ExtDirect\Tests\Service\Services\Service1();

        $container->expects($this->once())
            ->method('get')
            ->with($this->equalTo('app.direct.test'))
            ->willReturn($service);

        $factory = new ContainerServiceFactory($container);

        $this->assertSame($service, $factory->createService($classMetadata));
    }

    public function testServiceFactoryWithoutServiceId()
    {
        $classMetadata = $this->loadMetadataForClass('GT\ExtDirect\Tests\Service\Services\Service2');

        $container = $this->createContainer();
        $container->expects($this->never())
            ->method('get');

        $factory = new ContainerServiceFactory($container);

        $this->assertEquals(
            new \GT\ExtDirect\Tests\Service\Services\Service2(),
            $factory->createService($classMetadata)
        );
    }

    public function testServiceFactoryWithoutServiceIdAndContainerAwareService()
    {
        $classMetadata = $this->loadMetadataForClass('GT\ExtDirect\Tests\Service\Services\Service3');

        $container = $this->createContainer();
        $container->expects($this->never())
            ->method('get');

        $factory = new ContainerServiceFactory($container);

        $service = new \GT\ExtDirect\Tests\Service\Services\Service3();
        $service->setContainer($container);

        /** @var \GT\ExtDirect\Tests\Service\Services\Service3 $createdService */
        $createdService = $factory->createService($classMetadata);

        $this->assertEquals($service, $createdService);
        $this->assertSame($container, $createdService->getContainer());
    }


    public function testServiceFactoryCannotInstantiateServiceWithComplicatedConstructor()
    {
        $classMetadata = $this->loadMetadataForClass('GT\ExtDirect\Tests\Service\Services\Service4');

        $container = $this->createContainer();
        $factory = new ContainerServiceFactory($container);

        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('Cannot instantiate action');
        $factory->createService($classMetadata);
    }

    /**
     * @return MockObject|\Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function createContainer()
    {
        /** @var \Symfony\Component\DependencyInjection\ContainerInterface|MockObject $container */
        $container = $this->createMock('Symfony\Component\DependencyInjection\ContainerInterface');
        return $container;
    }

    /**
     * @param string $className
     * @return \Metadata\ClassMetadata|\GT\ExtDirect\Metadata\ActionMetadata|null
     */
    protected function loadMetadataForClass($className)
    {
        $driver = new AnnotationDriver(new AnnotationReader());
        $reflectionClass = new \ReflectionClass($className);
        $classMetadata = $driver->loadMetadataForClass($reflectionClass);
        return $classMetadata;
    }

}
