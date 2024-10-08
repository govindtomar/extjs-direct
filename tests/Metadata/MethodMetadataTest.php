<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 23.07.15
 * Time: 11:01
 */

namespace GT\ExtDirect\Tests\Metadata;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use GT\ExtDirect\Metadata\Driver\AnnotationDriver;

/**
 * Class MethodMetadataTest
 *
 * @package GT\ExtDirect\Tests\Metadata
 */
class MethodMetadataTest extends TestCase
{
    public function testSerialize()
    {
        $driver          = new AnnotationDriver(new AnnotationReader());
        $reflectionClass = new \ReflectionClass('GT\ExtDirect\Tests\Metadata\Services\Service1');
        $origMetadata    = $driver->loadMetadataForClass($reflectionClass);

        $serialized = serialize($origMetadata);
        /** @var \GT\ExtDirect\Metadata\ActionMetadata $restoredMetadata */
        $restoredMetadata = unserialize($serialized);

        /** @var \GT\ExtDirect\Metadata\MethodMetadata $origMethodMetadata */
        /** @var \GT\ExtDirect\Metadata\MethodMetadata $restoredMethodMetadata */
        $origMethodMetadata     = $origMetadata->methodMetadata['methodA'];
        $restoredMethodMetadata = $restoredMetadata->methodMetadata['methodA'];

        $this->assertEquals($origMethodMetadata->isMethod, $restoredMethodMetadata->isMethod);
        $this->assertEquals($origMethodMetadata->isFormHandler, $restoredMethodMetadata->isFormHandler);
        $this->assertEquals($origMethodMetadata->hasNamedParams, $restoredMethodMetadata->hasNamedParams);
        $this->assertEquals($origMethodMetadata->isStrict, $restoredMethodMetadata->isStrict);
        $this->assertEquals($origMethodMetadata->batched, $restoredMethodMetadata->batched);

        $this->assertEquals(count($origMethodMetadata->parameters), count($restoredMethodMetadata->parameters));
        $this->assertEquals(count($origMethodMetadata->parameterMetadata),
            count($restoredMethodMetadata->parameterMetadata));

        $this->assertEquals($origMethodMetadata->authorizationExpression, $restoredMethodMetadata->authorizationExpression);
        $this->assertEquals($origMethodMetadata->result, $restoredMethodMetadata->result);
    }
}
