<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Description;

use Symfony\Component\HttpFoundation\Request as HttpRequest;
use GT\ExtDirect\Metadata\MethodMetadata;
use GT\ExtDirect\Router\ArgumentValidationResult;
use GT\ExtDirect\Router\Request as DirectRequest;
use GT\ExtDirect\Service\ServiceRegistry;

/**
 * Class ServiceDescriptionFactory
 *
 * @package GT\ExtDirect\Service
 */
class ServiceDescriptionFactory
{
    /**
     * @var ServiceRegistry
     */
    private $serviceRegistry;

    /**
     * @var string
     */
    private $namespace;

    /**
     * @var bool|int|null
     */
    private $enableBuffer;

    /**
     * @var int|null
     */
    private $bufferLimit;

    /**
     * @var int|null
     */
    private $timeout;

    /**
     * @var int|null
     */
    private $maxRetries;

    /**
     * @param ServiceRegistry $serviceRegistry
     * @param string $namespace
     * @param boolean|int|null $enableBuffer
     * @param int|null $bufferLimit
     * @param int|null $timeout
     * @param int|null $maxRetries
     */
    public function __construct(
        ServiceRegistry $serviceRegistry,
        $namespace,
        $enableBuffer = null,
        $bufferLimit = null,
        $timeout = null,
        $maxRetries = null
    ) {
        $this->serviceRegistry = $serviceRegistry;
        $this->namespace       = $namespace;
        $this->enableBuffer    = (is_int($enableBuffer) || is_bool($enableBuffer)) ? $enableBuffer : null;
        $this->bufferLimit     = is_int($bufferLimit) ? $bufferLimit : null;
        $this->timeout         = is_int($timeout) ? $timeout : null;
        $this->maxRetries      = is_int($maxRetries) ? $maxRetries : null;
    }

    /**
     * @param string $url
     * @return ServiceDescription
     */
    public function createServiceDescription($url)
    {
        $serviceDescription = new ServiceDescription(
            $url,
            $this->namespace,
            $this->enableBuffer,
            $this->bufferLimit,
            $this->timeout,
            $this->maxRetries
        );

        foreach ($this->serviceRegistry->getAllServices() as $actionMetadata) {
            if (!$actionMetadata) {
                continue;
            }

            $actionDescription = new ActionDescription($actionMetadata->alias);
            foreach ($actionMetadata->methodMetadata as $methodMetadata) {
                /** @var MethodMetadata $methodMetadata */

                if (!$methodMetadata->isMethod) {
                    continue;
                }

                $parameters = [];
                foreach ($methodMetadata->parameters as $parameter) {
                    if (($class = $parameter->getType()) === null
                        || !in_array(
                            $class->getName(),
                            [HttpRequest::class, DirectRequest::class, ArgumentValidationResult::class]
                        )
                    ) {
                        $parameters[] = $parameter->getName();
                    }
                }

                $actionDescription->addMethod(
                    new MethodDescription(
                        $methodMetadata->name,
                        $methodMetadata->isFormHandler,
                        $parameters,
                        $methodMetadata->hasNamedParams,
                        $methodMetadata->isStrict,
                        $methodMetadata->batched
                    )
                );
            }

            if (count($actionDescription->getMethods())) {
                $serviceDescription->addAction($actionDescription);
            }
        }

        return $serviceDescription;
    }
}
