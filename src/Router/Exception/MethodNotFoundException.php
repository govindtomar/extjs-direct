<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router\Exception;

use GT\ExtDirect\Router\Request as DirectRequest;

/**
 * Class MethodNotFoundException
 *
 * @package GT\ExtDirect\Router\Exception
 */
class MethodNotFoundException extends AbstractResolverException
{
    /**
     * @param DirectRequest $request
     * @param \Exception    $previous
     */
    public function __construct(DirectRequest $request, \Exception $previous = null)
    {
        parent::__construct($request, sprintf('The method "%s" cannot be found', $request->getMethod()), $previous);
    }
}
