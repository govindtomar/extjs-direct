<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router;

use GT\ExtDirect\Router\Exception\ArgumentValidationException;
use GT\ExtDirect\Router\Exception\StrictArgumentValidationException;


/**
 * Class ArgumentValidator
 *
 * @package GT\ExtDirect\Router
 */
interface ArgumentValidatorInterface
{
    /**
     * @param ServiceReference $service
     * @param array            $arguments
     * @throws StrictArgumentValidationException
     * @throws ArgumentValidationException
     */
    public function validate(ServiceReference $service, array $arguments);
}
