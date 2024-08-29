<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 17:30
 */

namespace GT\ExtDirect\Tests\Metadata\Driver\Services\Sub;

use GT\ExtDirect\Annotation as Direct;
use GT\ExtDirect\Tests\Metadata\Driver\Services\Service4;

/**
 * Class Service3
 *
 * @package GT\ExtDirect\Tests\Metadata\Driver\Services
 *
 * @Direct\Action("app.direct.test")
 */
class Service6 extends Service4
{
    /**
     * @Direct\Method()
     */
    public function methodA()
    {
    }
}
