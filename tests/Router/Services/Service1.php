<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 24.07.15
 * Time: 12:53
 */

namespace GT\ExtDirect\Tests\Router\Services;

use Symfony\Component\Validator\Constraints as Assert;
use GT\ExtDirect\Annotation as Direct;

/**
 * Class Service1
 *
 * @package GT\ExtDirect\Tests\Router\Services
 *
 * @Direct\Action("app.direct.test")
 */
class Service1
{
    /**
     * @Direct\Method()
     */
    public function methodA()
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() })
     *
     * @param mixed $a
     */
    public function methodB($a)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() })
     *
     * @param mixed                                     $a
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function methodC($a, \Symfony\Component\HttpFoundation\Request $request)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() })
     *
     * @param mixed                        $a
     * @param \GT\ExtDirect\Router\Request $request
     */
    public function methodD($a, \GT\ExtDirect\Router\Request $request)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() })
     *
     * @param mixed                                     $a
     * @param \GT\ExtDirect\Router\Request              $request1
     * @param \Symfony\Component\HttpFoundation\Request $request2
     */
    public function methodE(
        $a,
        \GT\ExtDirect\Router\Request $request1,
        \Symfony\Component\HttpFoundation\Request $request2
    ) {
    }

    /**
     * @Direct\Method()
     */
    public static function methodF()
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() })
     *
     * @param mixed                                         $a
     * @param \GT\ExtDirect\Router\ArgumentValidationResult $result
     */
    public function methodG($a, \GT\ExtDirect\Router\ArgumentValidationResult $result = null)
    {
    }

    /**
     * @Direct\Method()
     * @Direct\Parameter("a", { @Assert\NotNull() })
     *
     * @param mixed                                         $a
     * @param \GT\ExtDirect\Router\ArgumentValidationResult $result
     */
    public function methodH($a, \GT\ExtDirect\Router\ArgumentValidationResult $result)
    {
    }
}
