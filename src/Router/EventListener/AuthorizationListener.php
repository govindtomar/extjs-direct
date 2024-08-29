<?php
/**
 * Created by PhpStorm.
 * User: stefan
 * Date: 21.01.16
 * Time: 16:58
 */

namespace GT\ExtDirect\Router\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use GT\ExtDirect\Router\AuthorizationCheckerInterface;
use GT\ExtDirect\Router\Event\ServiceResolveEvent;
use GT\ExtDirect\Router\Exception\NotAuthorizedException;
use GT\ExtDirect\Router\RouterEvents;

/**
 * Class AuthorizationListener
 *
 * @package GT\ExtDirect\Router\EventListener
 */
class AuthorizationListener implements EventSubscriberInterface
{
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return array(
            RouterEvents::AFTER_RESOLVE => array('onAfterResolve', 0)
        );
    }

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param ServiceResolveEvent $event
     */
    public function onAfterResolve(ServiceResolveEvent $event)
    {
        if (!$this->authorizationChecker->isGranted($event->getService(), $event->getArguments())) {
            throw new NotAuthorizedException();
        }
    }
}
