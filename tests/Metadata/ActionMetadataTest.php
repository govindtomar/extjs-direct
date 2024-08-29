<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 23.07.15
 * Time: 10:54
 */

namespace GT\ExtDirect\Tests\Metadata;

use Doctrine\Common\Annotations\AnnotationReader;
use PHPUnit\Framework\TestCase;
use GT\ExtDirect\Metadata\Driver\AnnotationDriver;
use GT\ExtDirect\Metadata\Driver\PathAnnotationDriver;

/**
 * Class ActionMetadataTest
 *
 * @package GT\ExtDirect\Tests\Metadata
 */
class ActionMetadataTest extends TestCase
{
    public function testSerialize()
    {
        $driver          = new AnnotationDriver(new AnnotationReader());
        $reflectionClass = new \ReflectionClass('GT\ExtDirect\Tests\Metadata\Services\Service1');
        $origMetadata    = $driver->loadMetadataForClass($reflectionClass);

        $serialized = serialize($origMetadata);
        /** @var \GT\ExtDirect\Metadata\ActionMetadata $restoredMetadata */
        $restoredMetadata = unserialize($serialized);

        $this->assertEquals($origMetadata->isAction, $restoredMetadata->isAction);
        $this->assertEquals($origMetadata->serviceId, $restoredMetadata->serviceId);
        $this->assertEquals($origMetadata->alias, $restoredMetadata->alias);
        $this->assertEquals($origMetadata->authorizationExpression, $restoredMetadata->authorizationExpression);

        $this->assertEquals(count($origMetadata->methodMetadata), count($restoredMetadata->methodMetadata));
    }
}
