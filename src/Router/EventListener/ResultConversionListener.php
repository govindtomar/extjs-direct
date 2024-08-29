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
use GT\ExtDirect\Router\Event\InvokeEvent;
use GT\ExtDirect\Router\ResultConverterInterface;
use GT\ExtDirect\Router\RouterEvents;

/**
 * Class ResultConversionListener
 *
 * @package GT\ExtDirect\Router\EventListener
 */
class ResultConversionListener implements EventSubscriberInterface
{
    /**
     * @var ResultConverterInterface
     */
    private $converter;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            RouterEvents::AFTER_INVOKE => array('onAfterInvoke', -128)
        );
    }

    /**
     * @param ResultConverterInterface $converter
     */
    public function __construct(ResultConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @param InvokeEvent $event
     */
    public function onAfterInvoke(InvokeEvent $event)
    {
        $event->setResult($this->converter->convert($event->getService(), $event->getResult()));
    }
}
