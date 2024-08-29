<?php
/**
 * govindtomar/ext-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use GT\ExtDirect\Router\ArgumentValidatorInterface;
use GT\ExtDirect\Router\Event\ServiceResolveEvent;
use GT\ExtDirect\Router\Exception\ArgumentValidationException;
use GT\ExtDirect\Router\RouterEvents;

/**
 * Class ArgumentValidationListener
 *
 * @package GT\ExtDirect\Router\EventListener
 */
class ArgumentValidationListener implements EventSubscriberInterface
{
    /**
     * @var ArgumentValidatorInterface
     */
    private $validator;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            RouterEvents::AFTER_RESOLVE => array('onAfterResolve', -128)
        );
    }

    /**
     * @param ArgumentValidatorInterface $validator
     */
    public function __construct(ArgumentValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param ServiceResolveEvent $event
     */
    public function onAfterResolve(ServiceResolveEvent $event)
    {
        try {
            $this->validator->validate($event->getService(), $event->getArguments());
        } catch (ArgumentValidationException $e) {
            if ($e->isStrictFailure()) {
                throw $e;
            }
            $event->setArguments(
                array_replace(
                    $event->getArguments(),
                    [
                        '__internal__validation_result__' => $e->getResult()
                    ]
                )
            );
        }
    }
}
