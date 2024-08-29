<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router;

use Symfony\Component\HttpFoundation\Request as HttpRequest;
use GT\ExtDirect\Router\Request as DirectRequest;


/**
 * Class ServiceResolver
 *
 * @package GT\ExtDirect\Service
 */
interface ServiceResolverInterface
{
    /**
     * @param DirectRequest $directRequest
     * @return ServiceReference
     */
    public function getService(DirectRequest $directRequest);

    /**
     * @param DirectRequest $directRequest
     * @param HttpRequest   $httpRequest
     * @return array
     */
    public function getArguments(DirectRequest $directRequest, HttpRequest $httpRequest);
}
