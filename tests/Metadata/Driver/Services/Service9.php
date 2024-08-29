<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 17:30
 */

namespace GT\ExtDirect\Tests\Metadata\Driver\Services;

use Symfony\Component\Validator\Constraints as Assert;
use GT\ExtDirect\Annotation as Direct;

/**
 * Class Service9
 *
 * @package GT\ExtDirect\Tests\Metadata\Driver\Services
 *
 * @Direct\Action()
 */
class Service9
{
    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() }, strict=true)
     *
     * @param string $a
     */
    public function methodA($a)
    {
    }
}
