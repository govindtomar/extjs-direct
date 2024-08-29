<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 27.07.15
 * Time: 10:00
 */

namespace GT\ExtDirect\Tests\Router;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use GT\ExtDirect\Router\ArgumentConverter;

/**
 * Class ArgumentConverterTest
 *
 * @package GT\ExtDirect\Tests\Router
 */
class ArgumentConverterTest extends TestCase
{
    public function testNonArrayArgumentIsNotConverted()
    {
        /** @var \JMS\Serializer\ArrayTransformerInterface|MockObject $transformer */
        $transformer = $this->createMock('\JMS\Serializer\ArrayTransformerInterface');
        $transformer->expects($this->never())
                    ->method('fromArray');

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service = $this->createPartialMock('GT\ExtDirect\Router\ServiceReference', array('getParameter'));
        $service->expects($this->once())
                ->method('getParameter')
                ->with($this->equalTo('a'))
                ->willReturn(
                    new \ReflectionParameter(
                        array('GT\ExtDirect\Tests\Router\ArgumentConverterTest', 'serviceIntegerArgument'),
                        'a'
                    )
                );

        $converter = new ArgumentConverter($transformer);

        $this->assertEquals(
            array(
                'a' => 1
            ),
            $converter->convert($service, array(
                'a' => 1
            ))
        );
    }

    public function testArgumentsIsNotConvertedForNonExistingParameters()
    {
        /** @var \JMS\Serializer\ArrayTransformerInterface|MockObject $transformer */
        $transformer = $this->createMock('\JMS\Serializer\ArrayTransformerInterface');
        $transformer->expects($this->never())
                    ->method('fromArray');

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service = $this->createPartialMock('GT\ExtDirect\Router\ServiceReference', array('getParameter'));
        $service->expects($this->once())
                ->method('getParameter')
                ->with($this->equalTo('b'))
                ->willReturn(null);

        $converter = new ArgumentConverter($transformer);

        $this->assertEquals(
            array(
                'b' => 1
            ),
            $converter->convert($service, array(
                'b' => 1
            ))
        );
    }

    public function testArrayArgumentIsNotConvertedForNonTypedParameter()
    {
        /** @var \JMS\Serializer\ArrayTransformerInterface|MockObject $transformer */
        $transformer = $this->createMock('\JMS\Serializer\ArrayTransformerInterface');
        $transformer->expects($this->never())
                    ->method('fromArray');

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service = $this->createPartialMock('GT\ExtDirect\Router\ServiceReference', array('getParameter'));
        $service->expects($this->once())
                ->method('getParameter')
                ->with($this->equalTo('a'))
                ->willReturn(
                    new \ReflectionParameter(
                        array('GT\ExtDirect\Tests\Router\ArgumentConverterTest', 'serviceArrayArgument'),
                        'a'
                    )
                );

        $converter = new ArgumentConverter($transformer);

        $this->assertEquals(
            array(
                'a' => array(1, 2, 3)
            ),
            $converter->convert($service, array(
                'a' => array(1, 2, 3)
            ))
        );
    }

    public function testArrayArgumentIsConvertedForTypedParameter()
    {
        $argument = new ArgumentConverterTest_TestClass(1);
    
        /** @var \JMS\Serializer\ArrayTransformerInterface|MockObject $transformer */
        $transformer = $this->createMock('\JMS\Serializer\ArrayTransformerInterface');
        $transformer->expects($this->once())
                    ->method('fromArray')
                    ->with(
                        $this->equalTo(['id' => 1]),
                        $this->equalTo('GT\ExtDirect\Tests\Router\ArgumentConverterTest_TestClass')
                    )
                    ->willReturn($argument);
    
        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service = $this->createPartialMock('GT\ExtDirect\Router\ServiceReference', array('getParameter'));
        $service->expects($this->once())
                ->method('getParameter')
                ->with($this->equalTo('a'))
                ->willReturn(
                    new \ReflectionParameter(
                        array('GT\ExtDirect\Tests\Router\ArgumentConverterTest', 'serviceObjectArgument'),
                        'a'
                    )
                );

        $converter = new ArgumentConverter($transformer);

        $this->assertEquals(
            array(
                'a' => $argument

            ),
            $converter->convert($service, array(
                'a' => array('id' => 1)
            ))
        );
    }

    public function testArgumentsIsNotConvertedForInternalParameters()
    {
        /** @var \JMS\Serializer\ArrayTransformerInterface|MockObject $transformer */
        $transformer = $this->createMock('\JMS\Serializer\ArrayTransformerInterface');
        $transformer->expects($this->never())
                    ->method('fromArray');

        /** @var \GT\ExtDirect\Router\ServiceReference|MockObject $service */
        $service = $this->createPartialMock('GT\ExtDirect\Router\ServiceReference', array('getParameter'));
        $service->expects($this->never())
                ->method('getParameter');

        $converter = new ArgumentConverter($transformer);

        $this->assertEquals(
            array(
                '__internal__a' => 1
            ),
            $converter->convert($service, array(
                '__internal__a' => 1
            ))
        );
    }

    /**
     * @param int $a
     */
    public static function serviceIntegerArgument($a)
    {
    }

    /**
     * @param array $a
     */
    public static function serviceArrayArgument(array $a)
    {
    }

    /**
     * @param ArgumentConverterTest_TestClass $a
     */
    public static function serviceObjectArgument(ArgumentConverterTest_TestClass $a)
    {
    }
}


/**
 * Class ArgumentConverterTest_TestClass
 *
 * @package GT\ExtDirect\Tests\Router
 */
class ArgumentConverterTest_TestClass
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }
}
