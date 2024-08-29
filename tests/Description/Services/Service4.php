<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 24.07.15
 * Time: 12:14
 */

namespace GT\ExtDirect\Tests\Description\Services;

use GT\ExtDirect\Annotation as Direct;

/**
 * Class Service4
 *
 * @package GT\ExtDirect\Tests\Description\Services
 *
 * @Direct\Action()
 */
class Service4
{
    /**
     * @Direct\Method()
     */
    public function methodA()
    {
    }

    /**
     * @Direct\Method(true)
     */
    public function methodB()
    {
    }
}
