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
use GT\ExtDirect\Router\ServiceReference;

/**
 * Class ServiceResolveEvent
 *
 * @package GT\ExtDirect\Router\Event
 */
class ServiceResolveEvent extends AbstractRouterEvent
{
    /**
     * @var ServiceReference|null
     */
    private $service;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @param DirectRequest         $directRequest
     * @param HttpRequest           $httpRequest
     * @param ServiceReference|null $service
     * @param array                 $arguments
     */
    public function __construct(
        DirectRequest $directRequest,
        HttpRequest $httpRequest,
        ServiceReference $service = null,
        array $arguments = array()
    ) {
        parent::__construct($directRequest, $httpRequest);
        $this->service   = $service;
        $this->arguments = $arguments;
    }

    /**
     * @return ServiceReference|null
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param ServiceReference|null $service
     * @return $this
     */
    public function setService(ServiceReference $service = null)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     * @return $this
     */
    public function setArguments(array $arguments = array())
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasBeenResolved()
    {
        return $this->service !== null;
    }
}
