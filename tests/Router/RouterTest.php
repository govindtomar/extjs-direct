<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 27.07.15
 * Time: 11:44
 */

namespace GT\ExtDirect\Tests\Router;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use GT\ExtDirect\Router\Request as DirectRequest;
use GT\ExtDirect\Router\RequestCollection;
use GT\ExtDirect\Router\Router;

/**
 * Class RouterTest
 *
 * @package GT\ExtDirect\Tests\Router
 */
class RouterTest extends TestCase
{
    public function testSuccessfulMethodCall()
    {
        /** @var \GT\ExtDirect\Router\ServiceResolverInterface|MockObject $serviceResolver */
        $serviceResolver = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceResolverInterface',
            array('getService', 'getArguments')
        );

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceReference',
            array('__invoke', 'hasSession')
        );

        $httpRequest = new HttpRequest();
        $directRequest = new DirectRequest(1, 'My.Action', 'myMethod', array('a', 'b'), false, false);

        $serviceResolver->expects($this->once())
            ->method('getService')
            ->with($this->equalTo($directRequest))
            ->willReturn($service);

        $serviceResolver->expects(($this->once()))
            ->method('getArguments')
            ->with($this->equalTo($directRequest), $this->equalTo($httpRequest))
            ->willReturn(array(
                '__internal__directRequest' => $directRequest,
                '__internal__httpRequest' => $httpRequest,
                'a' => 'a',
                'b' => 'b'
            ));

        $service->expects($this->any())
            ->method('hasSession')
            ->willReturn(true);
        $service->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->equalTo(
                    array(
                        $directRequest,
                        $httpRequest,
                        'a',
                        'b'
                    )
                )
            )
            ->willReturn(1);

        $router = new Router($serviceResolver);
        $response = $router->handle(new RequestCollection(array($directRequest)), $httpRequest);


        $this->assertInstanceOf('GT\ExtDirect\Router\ResponseCollection', $response);
        $this->assertCount(1, $response);

        /** @var \GT\ExtDirect\Router\RPCResponse $firstResponse */
        $firstResponse = $response->getFirst();
        $this->assertInstanceOf('GT\ExtDirect\Router\RPCResponse', $firstResponse);

        $this->assertEquals(1, $firstResponse->getTid());
        $this->assertEquals('My.Action', $firstResponse->getAction());
        $this->assertEquals('myMethod', $firstResponse->getMethod());
        $this->assertEquals(1, $firstResponse->getResult());
    }

    public function testSuccessfulBatchedMethodsCall()
    {
        /** @var \GT\ExtDirect\Router\ServiceResolverInterface|MockObject $serviceResolver */
        $serviceResolver = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceResolverInterface',
            array('getService', 'getArguments')
        );

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service1 = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceReference',
            array('__invoke', 'hasSession')
        );

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service2 = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceReference',
            array('__invoke', 'hasSession')
        );

        $httpRequest = new HttpRequest();
        $directRequest1 = new DirectRequest(1, 'My.Action', 'myMethod1', array('a', 'b'), false, false);
        $directRequest2 = new DirectRequest(2, 'My.Action', 'myMethod2', array('c', 'd'), false, false);

        $serviceResolver->expects($this->exactly(2))
            ->method('getService')
            ->withConsecutive(
                array($this->equalTo($directRequest1)),
                array($this->equalTo($directRequest2))
            )
            ->willReturnOnConsecutiveCalls($service1, $service2);

        $serviceResolver->expects(($this->exactly(2)))
            ->method('getArguments')
            ->withConsecutive(
                array($this->equalTo($directRequest1), $this->equalTo($httpRequest)),
                array($this->equalTo($directRequest2), $this->equalTo($httpRequest))
            )
            ->willReturnOnConsecutiveCalls(
                array(
                    '__internal__directRequest' => $directRequest1,
                    '__internal__httpRequest' => $httpRequest,
                    'a' => 'a',
                    'b' => 'b'
                ),
                array(
                    '__internal__directRequest' => $directRequest2,
                    '__internal__httpRequest' => $httpRequest,
                    'a' => 'c',
                    'b' => 'd'
                )
            );

        $service1->expects($this->any())
            ->method('hasSession')
            ->willReturn(true);
        $service1->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->equalTo(
                    array(
                        $directRequest1,
                        $httpRequest,
                        'a',
                        'b'
                    )
                )
            )
            ->willReturn(1);

        $service2->expects($this->any())
            ->method('hasSession')
            ->willReturn(true);
        $service2->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->equalTo(
                    array(
                        $directRequest2,
                        $httpRequest,
                        'c',
                        'd'
                    )
                )
            )
            ->willReturn(2);

        $router = new Router($serviceResolver);
        $response = $router->handle(new RequestCollection(array($directRequest1, $directRequest2)), $httpRequest);


        $this->assertInstanceOf('GT\ExtDirect\Router\ResponseCollection', $response);
        $this->assertCount(2, $response);

        /** @var \GT\ExtDirect\Router\RPCResponse $firstResponse */
        $firstResponse = $response->getAt(0);
        $this->assertInstanceOf('GT\ExtDirect\Router\RPCResponse', $firstResponse);

        $this->assertEquals(1, $firstResponse->getTid());
        $this->assertEquals('My.Action', $firstResponse->getAction());
        $this->assertEquals('myMethod1', $firstResponse->getMethod());
        $this->assertEquals(1, $firstResponse->getResult());

        /** @var \GT\ExtDirect\Router\RPCResponse $secondResponse */
        $secondResponse = $response->getAt(1);
        $this->assertInstanceOf('GT\ExtDirect\Router\RPCResponse', $secondResponse);

        $this->assertEquals(2, $secondResponse->getTid());
        $this->assertEquals('My.Action', $secondResponse->getAction());
        $this->assertEquals('myMethod2', $secondResponse->getMethod());
        $this->assertEquals(2, $secondResponse->getResult());
    }

    public function testFailedMethodCall()
    {
        /** @var \GT\ExtDirect\Router\ServiceResolverInterface|MockObject $serviceResolver */
        $serviceResolver = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceResolverInterface',
            array('getService', 'getArguments')
        );

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceReference',
            array('__invoke', 'hasSession')
        );

        $httpRequest = new HttpRequest();
        $directRequest = new DirectRequest(1, 'My.Action', 'myMethod', array('a', 'b'), false, false);

        $serviceResolver->expects($this->once())
            ->method('getService')
            ->with($this->equalTo($directRequest))
            ->willReturn($service);

        $serviceResolver->expects(($this->once()))
            ->method('getArguments')
            ->with($this->equalTo($directRequest), $this->equalTo($httpRequest))
            ->willReturn(array(
                '__internal__directRequest' => $directRequest,
                '__internal__httpRequest' => $httpRequest,
                'a' => 'a',
                'b' => 'b'
            ));

        $service->expects($this->any())
            ->method('hasSession')
            ->willReturn(true);
        $exception = new \RuntimeException('Something has happened');
        $service->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->equalTo(
                    array(
                        $directRequest,
                        $httpRequest,
                        'a',
                        'b'
                    )
                )
            )
            ->willThrowException($exception);

        $router = new Router($serviceResolver);
        $response = $router->handle(new RequestCollection(array($directRequest)), $httpRequest);

        $this->assertInstanceOf('GT\ExtDirect\Router\ResponseCollection', $response);
        $this->assertCount(1, $response);

        /** @var \GT\ExtDirect\Router\ExceptionResponse $firstResponse */
        $firstResponse = $response->getFirst();
        $this->assertInstanceOf('GT\ExtDirect\Router\ExceptionResponse', $firstResponse);

        $this->assertEquals(1, $firstResponse->getTid());
        $this->assertEquals('My.Action', $firstResponse->getAction());
        $this->assertEquals('myMethod', $firstResponse->getMethod());
        $this->assertSame($exception, $firstResponse->getException());
    }

    public function testPartiallySuccessfulBatchedMethodsCall()
    {
        /** @var \GT\ExtDirect\Router\ServiceResolverInterface|MockObject $serviceResolver */
        $serviceResolver = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceResolverInterface',
            array('getService', 'getArguments')
        );

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service1 = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceReference',
            array('__invoke', 'hasSession')
        );

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service2 = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceReference',
            array('__invoke', 'hasSession')
        );

        $httpRequest = new HttpRequest();
        $directRequest1 = new DirectRequest(1, 'My.Action', 'myMethod1', array('a', 'b'), false, false);
        $directRequest2 = new DirectRequest(2, 'My.Action', 'myMethod2', array('c', 'd'), false, false);

        $serviceResolver->expects($this->exactly(2))
            ->method('getService')
            ->withConsecutive(
                array($this->equalTo($directRequest1)),
                array($this->equalTo($directRequest2))
            )
            ->willReturnOnConsecutiveCalls($service1, $service2);

        $serviceResolver->expects(($this->exactly(2)))
            ->method('getArguments')
            ->withConsecutive(
                array($this->equalTo($directRequest1), $this->equalTo($httpRequest)),
                array($this->equalTo($directRequest2), $this->equalTo($httpRequest))
            )
            ->willReturnOnConsecutiveCalls(
                array(
                    '__internal__directRequest' => $directRequest1,
                    '__internal__httpRequest' => $httpRequest,
                    'a' => 'a',
                    'b' => 'b'
                ),
                array(
                    '__internal__directRequest' => $directRequest2,
                    '__internal__httpRequest' => $httpRequest,
                    'a' => 'c',
                    'b' => 'd'
                )
            );

        $service1->expects($this->any())
            ->method('hasSession')
            ->willReturn(true);
        $service1->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->equalTo(
                    array(
                        $directRequest1,
                        $httpRequest,
                        'a',
                        'b'
                    )
                )
            )
            ->willReturn(1);

        $service2->expects($this->any())
            ->method('hasSession')
            ->willReturn(true);
        $exception = new \RuntimeException('Something has happened');
        $service2->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->equalTo(
                    array(
                        $directRequest2,
                        $httpRequest,
                        'c',
                        'd'
                    )
                )
            )
            ->willThrowException($exception);

        $router = new Router($serviceResolver);
        $response = $router->handle(new RequestCollection(array($directRequest1, $directRequest2)), $httpRequest);


        $this->assertInstanceOf('GT\ExtDirect\Router\ResponseCollection', $response);
        $this->assertCount(2, $response);

        /** @var \GT\ExtDirect\Router\RPCResponse $firstResponse */
        $firstResponse = $response->getAt(0);
        $this->assertInstanceOf('GT\ExtDirect\Router\RPCResponse', $firstResponse);

        $this->assertEquals(1, $firstResponse->getTid());
        $this->assertEquals('My.Action', $firstResponse->getAction());
        $this->assertEquals('myMethod1', $firstResponse->getMethod());
        $this->assertEquals(1, $firstResponse->getResult());

        /** @var \GT\ExtDirect\Router\ExceptionResponse $secondResponse */
        $secondResponse = $response->getAt(1);
        $this->assertInstanceOf('GT\ExtDirect\Router\ExceptionResponse', $secondResponse);

        $this->assertEquals(2, $secondResponse->getTid());
        $this->assertEquals('My.Action', $secondResponse->getAction());
        $this->assertEquals('myMethod2', $secondResponse->getMethod());
        $this->assertSame($exception, $secondResponse->getException());
    }

    public function testEventDispatcherIsCalledCorrectlyForSuccessfulCall()
    {
        /** @var \GT\ExtDirect\Router\ServiceResolverInterface|MockObject $serviceResolver */
        $serviceResolver = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceResolverInterface',
            array('getService', 'getArguments')
        );

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceReference',
            array('__invoke', 'hasSession')
        );

        $httpRequest = new HttpRequest();
        $directRequest = new DirectRequest(1, 'My.Action', 'myMethod', array('a', 'b'), false, false);

        $serviceResolver->expects($this->once())
            ->method('getService')
            ->with($this->equalTo($directRequest))
            ->willReturn($service);

        $serviceResolver->expects(($this->once()))
            ->method('getArguments')
            ->with($this->equalTo($directRequest), $this->equalTo($httpRequest))
            ->willReturn(array(
                '__internal__directRequest' => $directRequest,
                '__internal__httpRequest' => $httpRequest,
                'a' => 'a',
                'b' => 'b'
            ));

        $service->expects($this->any())
            ->method('hasSession')
            ->willReturn(true);
        $service->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->equalTo(
                    array(
                        $directRequest,
                        $httpRequest,
                        'a',
                        'b'
                    )
                )
            )
            ->willReturn(1);


        $eventDispatcher = $this->createPartialMock(
            'Symfony\Component\EventDispatcher\EventDispatcherInterface',
            array(
                'dispatch',
                'addListener',
                'addSubscriber',
                'removeListener',
                'removeSubscriber',
                'getListeners',
                'getListenerPriority',
                'hasListeners',
            )
        );

        $calls = [
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\BeginRequestEvent'),
                $this->equalTo('tq_extdirect.router.begin_request'),
            ),
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\ServiceResolveEvent'),
                $this->equalTo('tq_extdirect.router.before_resolve'),
            ),
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\ServiceResolveEvent'),
                $this->equalTo('tq_extdirect.router.after_resolve'),
            ),
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\InvokeEvent'),
                $this->equalTo('tq_extdirect.router.before_invoke'),
            ),
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\InvokeEvent'),
                $this->equalTo('tq_extdirect.router.after_invoke'),
            ),
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\EndRequestEvent'),
                $this->equalTo('tq_extdirect.router.end_request'),
            )
        ];


        if (!class_exists(\Symfony\Contracts\EventDispatcher\Event::class)) {
            $calls = array_map('array_reverse', $calls);
        }
        $eventDispatcher->expects($this->exactly(6))
            ->method('dispatch')
            ->withConsecutive(...$calls)
            ->will($this->returnArgument(0));

        $router = new Router($serviceResolver, $eventDispatcher);
        $router->handle(new RequestCollection(array($directRequest)), $httpRequest);
    }


    public function testEventDispatcherIsCalledCorrectlyForFailedCall()
    {
        /** @var \GT\ExtDirect\Router\ServiceResolverInterface|MockObject $serviceResolver */
        $serviceResolver = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceResolverInterface',
            array('getService', 'getArguments')
        );

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service = $this->createPartialMock(
            'GT\ExtDirect\Router\ServiceReference',
            array('__invoke', 'hasSession')
        );

        $httpRequest = new HttpRequest();
        $directRequest = new DirectRequest(1, 'My.Action', 'myMethod', array('a', 'b'), false, false);

        $serviceResolver->expects($this->once())
            ->method('getService')
            ->with($this->equalTo($directRequest))
            ->willReturn($service);

        $serviceResolver->expects(($this->once()))
            ->method('getArguments')
            ->with($this->equalTo($directRequest), $this->equalTo($httpRequest))
            ->willReturn(array(
                '__internal__directRequest' => $directRequest,
                '__internal__httpRequest' => $httpRequest,
                'a' => 'a',
                'b' => 'b'
            ));

        $service->expects($this->any())
            ->method('hasSession')
            ->willReturn(true);
        $exception = new \RuntimeException('Something has happened');
        $service->expects($this->once())
            ->method('__invoke')
            ->with(
                $this->equalTo(
                    array(
                        $directRequest,
                        $httpRequest,
                        'a',
                        'b'
                    )
                )
            )
            ->willThrowException($exception);


        $eventDispatcher = $this->createPartialMock(
            'Symfony\Component\EventDispatcher\EventDispatcherInterface',
            array(
                'dispatch',
                'addListener',
                'addSubscriber',
                'removeListener',
                'removeSubscriber',
                'getListeners',
                'getListenerPriority',
                'hasListeners',
            )
        );

        $calls = [
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\BeginRequestEvent'),
                $this->equalTo('tq_extdirect.router.begin_request'),
            ),
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\ServiceResolveEvent'),
                $this->equalTo('tq_extdirect.router.before_resolve'),
            ),
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\ServiceResolveEvent'),
                $this->equalTo('tq_extdirect.router.after_resolve'),
            ),
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\InvokeEvent'),
                $this->equalTo('tq_extdirect.router.before_invoke'),
            ),
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\ExceptionEvent'),
                $this->equalTo('tq_extdirect.router.exception'),
            ),
            array(
                $this->isInstanceOf('GT\ExtDirect\Router\Event\EndRequestEvent'),
                $this->equalTo('tq_extdirect.router.end_request'),
            )
        ];
        if (!class_exists(\Symfony\Contracts\EventDispatcher\Event::class)) {
            $calls = array_map('array_reverse', $calls);
        }
        $eventDispatcher->expects($this->exactly(6))
            ->method('dispatch')
            ->withConsecutive(...$calls)
            ->will($this->returnArgument(0));

        $router = new Router($serviceResolver, $eventDispatcher);
        $router->handle(new RequestCollection(array($directRequest)), $httpRequest);
    }
}
