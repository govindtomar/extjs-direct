<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 17:30
 */

namespace GT\ExtDirect\Tests\Service\Services;

use Symfony\Component\Validator\Constraints as Assert;
use GT\ExtDirect\Annotation as Direct;

/**
 * Class Service1
 *
 * @package GT\ExtDirect\Tests\Service\Services
 *
 * @Direct\Action("app.direct.test")
 */
class Service1
{
    /**
     * @Direct\Method()
     *
     * @param mixed $a
     */
    public function methodA($a)
    {
    }
}
