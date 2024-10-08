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
 * Class Service10
 *
 * @package GT\ExtDirect\Tests\Metadata\Driver\Services
 *
 * @Direct\Action()
 */
class Service10
{
    /**
     * @Direct\Method()
     * @Direct\Result(groups={"a", "b"})
     */
    public function methodA()
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Result(attributes={"a": 1, "b": 2})
     */
    public function methodB()
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Result(version=1)
     */
    public function methodC()
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Result(groups={"a", "b"}, attributes={"a": 1, "b": 2}, version=1)
     */
    public function methodD()
    {
    }
}
