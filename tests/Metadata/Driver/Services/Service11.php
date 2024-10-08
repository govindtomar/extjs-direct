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
 * Class Service11
 *
 * @package GT\ExtDirect\Tests\Metadata\Driver\Services
 *
 * @Direct\Action()
 * @Direct\Security("true")
 */
class Service11
{
    /**
     * @Direct\Method()
     */
    public function methodA()
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Security("true and false")
     */
    public function methodB()
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Security(expression="true and true")
     */
    public function methodC()
    {
    }
}
