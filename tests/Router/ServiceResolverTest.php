<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 24.07.15
 * Time: 12:48
 */

namespace GT\ExtDirect\Tests\Router;

use Doctrine\Common\Annotations\AnnotationReader;
use Metadata\MetadataFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use GT\ExtDirect\Metadata\Driver\AnnotationDriver;
use GT\ExtDirect\Router\ArgumentValidationResult;
use GT\ExtDirect\Router\Request as DirectRequest;
use GT\ExtDirect\Router\ServiceResolver;
use GT\ExtDirect\Service\DefaultNamingStrategy;
use GT\ExtDirect\Service\DefaultServiceRegistry;
use GT\ExtDirect\Service\PathServiceLoader;

/**
 * Class ServiceResolverTest
 *
 * @package GT\ExtDirect\Tests\Router
 */
class ServiceResolverTest extends TestCase
{
    public function testGetService()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');

        /** @var \GT\ExtDirect\Tests\Router\Services\Service1|MockObject $service */
        $service = $this->createMock('GT\ExtDirect\Tests\Router\Services\Service1');

        $serviceFactory->expects($this->once())
                       ->method('createService')
                       ->with($this->isInstanceOf('GT\ExtDirect\Metadata\ActionMetadata'))
                       ->willReturn($service);

        $resolver = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodA', array(), false,
            false);

        $serviceReference = $resolver->getService($directRequest);

        $this->assertSame($service, $serviceReference->getService());
    }

    public function testInvokeService()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');

        /** @var \GT\ExtDirect\Tests\Router\Services\Service1|MockObject $service */
        $service = $this->createMock('GT\ExtDirect\Tests\Router\Services\Service1');

        $service->expects($this->once())
                ->method('methodA')
                ->with()
                ->willReturn(true);

        $serviceFactory->expects($this->once())
                       ->method('createService')
                       ->with($this->isInstanceOf('GT\ExtDirect\Metadata\ActionMetadata'))
                       ->willReturn($service);

        $resolver = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodA', array(), false,
            false);

        $serviceReference = $resolver->getService($directRequest);

        $this->assertSame($service, $serviceReference->getService());
        $this->assertTrue($serviceReference());
    }

    public function testGetNoArguments()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');
        $resolver       = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $httpRequest   = new HttpRequest();
        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodA', array(),
            false,
            false);

        $arguments = $resolver->getArguments($directRequest, $httpRequest);
        $this->assertCount(0, $arguments);
    }

    public function testGetOneArgument()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');
        $resolver       = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $httpRequest   = new HttpRequest();
        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodB', array('A'),
            false,
            false);

        $arguments = $resolver->getArguments($directRequest, $httpRequest);
        $this->assertCount(1, $arguments);
        $this->assertEquals(array('a' => 'A'), $arguments);
    }

    public function testGetOneArgumentWithHttpRequest()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');
        $resolver       = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $httpRequest   = new HttpRequest();
        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodC', array('A'),
            false,
            false);

        $arguments = $resolver->getArguments($directRequest, $httpRequest);
        $this->assertCount(2, $arguments);
        $this->assertEquals(array('a' => 'A', '__internal__http_request__' => $httpRequest), $arguments);
    }

    public function testGetOneArgumentWithDirectRequest()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');
        $resolver       = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $httpRequest   = new HttpRequest();
        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodD', array('A'),
            false,
            false);

        $arguments = $resolver->getArguments($directRequest, $httpRequest);
        $this->assertCount(2, $arguments);
        $this->assertEquals(array('a' => 'A', '__internal__direct_request__' => $directRequest), $arguments);
    }


    public function testGetOneArgumentWithHttpAndDirectRequest()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');
        $resolver       = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $httpRequest   = new HttpRequest();
        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodE', array('A'),
            false,
            false);

        $arguments = $resolver->getArguments($directRequest, $httpRequest);
        $this->assertCount(3, $arguments);
        $this->assertEquals(
            array(
                'a'                            => 'A',
                '__internal__direct_request__' => $directRequest,
                '__internal__http_request__'   => $httpRequest,
            ),
            $arguments
        );
    }

    public function testGetArgumentWithTooManyArguments()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');
        $resolver       = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $httpRequest   = new HttpRequest();
        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodB', array('A', 'B'),
            false,
            false);

        $arguments = $resolver->getArguments($directRequest, $httpRequest);
        $this->assertCount(1, $arguments);
        $this->assertEquals(array('a' => 'A'), $arguments);
    }

    public function testGetArgumentWithTooFewArguments()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');
        $resolver       = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $httpRequest   = new HttpRequest();
        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodB', array(),
            false,
            false);

        $arguments = $resolver->getArguments($directRequest, $httpRequest);
        $this->assertCount(1, $arguments);
        $this->assertEquals(array('a' => null), $arguments);
    }

    public function testGetArgumentWithOptionalArgumentValidationResult()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');
        $resolver       = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $httpRequest   = new HttpRequest();
        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodG', array('A'),
            false,
            false);

        $arguments = $resolver->getArguments($directRequest, $httpRequest);
        $this->assertCount(2, $arguments);
        $this->assertEquals(
            array('a' => 'A', '__internal__validation_result__' => new ArgumentValidationResult()),
            $arguments
        );
    }

    public function testGetArgumentWithArgumentValidationResult()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');
        $resolver       = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $httpRequest   = new HttpRequest();
        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodH', array('A'),
            false,
            false);

        $arguments = $resolver->getArguments($directRequest, $httpRequest);
        $this->assertCount(2, $arguments);
        $this->assertEquals(
            array('a' => 'A', '__internal__validation_result__' => new ArgumentValidationResult()),
            $arguments
        );
    }

    public function testGetStaticService()
    {
        /** @var \GT\ExtDirect\Service\ServiceFactory|MockObject $serviceFactory */
        $serviceFactory = $this->createMock('GT\ExtDirect\Service\ServiceFactory');

        $serviceFactory->expects($this->never())
                       ->method('createService');

        $resolver = new ServiceResolver(
            $this->createServiceRegistry(),
            $serviceFactory
        );

        $directRequest = new DirectRequest(1, 'GT.ExtDirect.Tests.Router.Services.Service1', 'methodF', array(), false,
            false);

        $serviceReference = $resolver->getService($directRequest);

        $this->assertEquals('GT\ExtDirect\Tests\Router\Services\Service1', $serviceReference->getService());
    }

    /**
     * @return DefaultServiceRegistry
     */
    protected function createServiceRegistry()
    {
        $registry = new DefaultServiceRegistry(
            new MetadataFactory(new AnnotationDriver(new AnnotationReader())),
            new DefaultNamingStrategy()
        );
        $registry->importServices(new PathServiceLoader([__DIR__ . '/Services']));
        return $registry;
    }
}
