<?php
/**
 * govindtomar/extjs-direct
 *
 * @category   GT
 * @package    GT\ExtDirect
 * @copyright  Copyright (C) 2015 by TEQneers GmbH & Co. KG
 */

namespace GT\ExtDirect\Router\EventListener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use GT\ExtDirect\Router\ArgumentConverterInterface;
use GT\ExtDirect\Router\Event\ServiceResolveEvent;
use GT\ExtDirect\Router\RouterEvents;

/**
 * Class ArgumentConversionListener
 *
 * @package GT\ExtDirect\Router\EventListener
 */
class ArgumentConversionListener implements EventSubscriberInterface
{
    /**
     * @var ArgumentConverterInterface
     */
    private $converter;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            RouterEvents::AFTER_RESOLVE => array('onAfterResolve', 128)
        );
    }

    /**
     * @param ArgumentConverterInterface $converter
     */
    public function __construct(ArgumentConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @param ServiceResolveEvent $event
     */
    public function onAfterResolve(ServiceResolveEvent $event)
    {
        $event->setArguments(
            $this->converter->convert(
                $event->getService(),
                $event->getArguments())
        );
    }
}
