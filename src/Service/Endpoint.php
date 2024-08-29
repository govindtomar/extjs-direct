<?php
/**
 * govindtomar/ext-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GT\ExtDirect\Description\ServiceDescriptionFactory;
use GT\ExtDirect\Http\ServiceDescriptionResponse;
use GT\ExtDirect\Http\UploadResponse;
use GT\ExtDirect\Router\RequestFactory;
use GT\ExtDirect\Router\Router;

/**
 * Class Endpoint
 *
 * @package GT\ExtDirect\Service
 */
class Endpoint
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var ServiceDescriptionFactory
     */
    private $descriptionFactory;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @var string
     */
    private string $descriptor;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @param string                    $id
     * @param ServiceDescriptionFactory $descriptionFactory
     * @param Router                    $router
     * @param RequestFactory            $requestFactory
     * @param string                    $descriptor
     * @param bool                      $debug
     */
    public function __construct(
        $id,
        ServiceDescriptionFactory $descriptionFactory,
        Router $router,
        RequestFactory $requestFactory,
        string $descriptor,
        $debug = false
    ) {
        $this->id                 = $id;
        $this->descriptionFactory = $descriptionFactory;
        $this->router             = $router;
        $this->requestFactory     = $requestFactory;
        $this->descriptor         = $descriptor;
        $this->debug              = $debug;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $url
     * @param string $format
     * @return ServiceDescriptionResponse
     */
    public function createServiceDescription($url, $format = 'js')
    {
        $serviceDescription = $this->descriptionFactory->createServiceDescription($url);

        if ($format == 'json') {
            $response = new JsonResponse($serviceDescription);
        } else {
            $response = new ServiceDescriptionResponse($serviceDescription, $this->getDescriptor());
        }

        if ($this->debug) {
            $response->setEncodingOptions(JSON_PRETTY_PRINT);
        }
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handleRequest(Request $request)
    {
        $directRequest  = $this->requestFactory->createRequest($request);
        $directResponse = $this->router->handle($directRequest, $request);

        if ($directRequest->isFormUpload()) {
            $response = new UploadResponse($directResponse->getFirst());
        } else {
            $response = new JsonResponse($directResponse);
        }

        if ($this->debug) {
            $response->setEncodingOptions(JSON_PRETTY_PRINT);
        }

        return $response;
    }

    /**
     * @return string
     */
    public function getDescriptor(): string
    {
        return $this->descriptor;
    }
}
