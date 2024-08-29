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
use GT\ExtDirect\Router\RequestCollection;

/**
 * Class BeginRequestEvent
 *
 * @package GT\ExtDirect\Router\Event
 */
class BeginRequestEvent extends Event
{
    /**
     * @var RequestCollection
     */
    private $directRequest;
    /**
     * @var HttpRequest
     */
    private $httpRequest;

    /**
     * @param RequestCollection $directRequest
     * @param HttpRequest $httpRequest
     */
    public function __construct(RequestCollection $directRequest, HttpRequest $httpRequest)
    {
        $this->directRequest = $directRequest;
        $this->httpRequest = $httpRequest;
    }

    /**
     * @return RequestCollection
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
