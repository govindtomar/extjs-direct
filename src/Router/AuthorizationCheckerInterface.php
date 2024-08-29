<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 21.01.16
 * Time: 16:58
 */

namespace GT\ExtDirect\Router;

/**
 * Interface AuthorizationCheckerInterface
 *
 * @package GT\ExtDirect\Router
 */
interface AuthorizationCheckerInterface
{
    /**
     * @param ServiceReference $service
     * @param array            $arguments
     * @return bool
     */
    public function isGranted(ServiceReference $service, array $arguments);
}
