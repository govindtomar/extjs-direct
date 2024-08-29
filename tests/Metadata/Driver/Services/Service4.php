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
 * Class Service4
 *
 * @package GT\ExtDirect\Tests\Metadata\Driver\Services
 *
 * @Direct\Action()
 */
class Service4
{
    /**
     * @Direct\Method(true)
     */
    public function methodB()
    {
    }
}
