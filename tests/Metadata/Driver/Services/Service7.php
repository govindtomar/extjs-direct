<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 17:30
 */

namespace GT\ExtDirect\Tests\Metadata\Driver\Services;

use GT\ExtDirect\Annotation as Direct;

/**
 * Class Service7
 *
 * @package GT\ExtDirect\Tests\Metadata\Driver\Services
 *
 * @Direct\Action()
 */
class Service7
{
    /**
     * @Direct\Method()
     */
    protected function methodA()
    {
    }

    /**
     * @Direct\Method()
     */
    private function methodB()
    {
    }
}
