<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 28.07.15
 * Time: 17:07
 */

namespace GT\ExtDirect\Tests\Router;

use PHPUnit\Framework\TestCase;
use GT\ExtDirect\Router\EventResponse;

/**
 * Class EventResponseTest
 *
 * @package GT\ExtDirect\Tests\Router
 */
class EventResponseTest extends TestCase
{
    public function testJsonSerialize()
    {
        $response = new EventResponse('newdata', array(1, 2, 3));

        $this->assertEquals(
            '{"type":"event","name":"newdata","data":[1,2,3]}',
            json_encode($response)
        );
    }
}
