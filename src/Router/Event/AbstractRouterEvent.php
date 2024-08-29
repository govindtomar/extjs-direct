<?php
/**
 * govindtomar/ext-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router\Event;


use Symfony\Component\HttpFoundation\Request as HttpRequest;
use GT\ExtDirect\Router\Request as DirectRequest;

/**
 * Class AbstractRouterEvent
 *
 * @package GT\ExtDirect\Router\Event
 */
abstract class AbstractRouterEvent extends Event
{
    /**
     * @var DirectRequest
     */
    private $directRequest;
    /**
     * @var HttpRequest
     */
    private $httpRequest;

    /**
     * @param DirectRequest $directRequest
     * @param HttpRequest $httpRequest
     */
    public function __construct(DirectRequest $directRequest, HttpRequest $httpRequest)
    {
        $this->directRequest = $directRequest;
        $this->httpRequest = $httpRequest;
    }

    /**
     * @return DirectRequest
     */
    public function getDirectRequest()
    {
        return $this->directRequest;
    }

    /**
     * @return HttpRequest
     */
    public function getHttpRequest()
    {
        return $this->httpRequest;
    }
}
