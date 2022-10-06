<?php

namespace App\Events;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Post;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class CurrentUserSubscriber implements EventSubscriberInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security=$security;
    }
    public static function getSubscribedEvents(){
        return [
            KernelEvents::VIEW => ["SetCurrentUser",EventPriorities::PRE_VALIDATE],
        ];
    }
        public function setCurrentUser(ViewEvent $event , string $method)
    {
        $post = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($post instanceof Post && $method === Request::METHOD_POST) {
            $post->setAuthor($this->security->getUser());
        }
    }
}