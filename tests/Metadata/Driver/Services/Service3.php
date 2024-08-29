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
 * Class Service3
 *
 * @package GT\ExtDirect\Tests\Metadata\Driver\Services
 *
 * @Direct\Action("app.direct.test")
 */
class Service3
{
    /**
     * @Direct\Method()
     */
    public function methodA()
    {
    }
}
