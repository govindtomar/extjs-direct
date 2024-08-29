<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 24.07.15
 * Time: 12:53
 */

namespace GT\ExtDirect\Tests\Router\Services;

use GT\ExtDirect\Annotation as Direct;

/**
 * Class Service2
 *
 * @package GT\ExtDirect\Tests\Router\Services
 */
class Service2
{
    /**
     * @Direct\Method(true)
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function methodA(\Symfony\Component\HttpFoundation\Request $request)
    {
    }

    /**
     * @Direct\Method(true)
     *
     * @param \GT\ExtDirect\Router\Request $request
     */
    public function methodB(\GT\ExtDirect\Router\Request $request)
    {
    }

    /**
     * @Direct\Method(true)
     *
     * @param \GT\ExtDirect\Router\Request              $request1
     * @param \Symfony\Component\HttpFoundation\Request $request2
     */
    public function methodC(\GT\ExtDirect\Router\Request $request1, \Symfony\Component\HttpFoundation\Request $request2)
    {
    }
}
