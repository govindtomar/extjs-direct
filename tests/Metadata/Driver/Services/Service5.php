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
 * Class Service5
 *
 * @package GT\ExtDirect\Tests\Metadata\Driver\Services
 *
 * @Direct\Action("app.direct.test")
 */
class Service5
{
    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() })
     *
     * @param mixed $a
     */
    public function methodA($a)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter("a", constraints={ @Assert\NotNull() })
     *
     * @param mixed $a
     */
    public function methodB($a)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter(name="a", constraints={ @Assert\NotNull() })
     *
     * @param mixed $a
     */
    public function methodC($a)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() }, {"myGroup"})
     *
     * @param mixed $a
     */
    public function methodD($a)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() }, validationGroups="myGroup")
     *
     * @param mixed $a
     */
    public function methodE($a)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter(name="a", constraints={ @Assert\NotNull() }, validationGroups="myGroup")
     *
     * @param mixed $a
     */
    public function methodF($a)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() }, validationGroups={"myGroup"})
     *
     * @param mixed $a
     */
    public function methodG($a)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter(name="a", constraints={ @Assert\NotNull() }, validationGroups={"myGroup"})
     *
     * @param mixed $a
     */
    public function methodH($a)
    {
    }
}
