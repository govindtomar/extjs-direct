<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 22.07.15
 * Time: 17:30
 */

namespace GT\ExtDirect\Tests\Service\Services;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Validator\Constraints as Assert;
use GT\ExtDirect\Annotation as Direct;

/**
 * Class Service3
 *
 * @package GT\ExtDirect\Tests\Service\Services
 *
 * @Direct\Action()
 */
class Service3 implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @Direct\Method()
     *
     * @param mixed $a
     */
    public function methodA($a)
    {
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
