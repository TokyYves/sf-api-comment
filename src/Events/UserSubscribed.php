<?php

namespace App\Events;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Authorization\AuthorizationChecker;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class UserSubscribed implements EventSubscriberInterface
{

    private $methodNotAllowed = [
        Request::METHOD_GET,
        Request::METHOD_POST
    ];

    private AuthorizationChecker $authorizationChecker;

    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker=$authorizationChecker;
    }
    public static function getSubscribedEvents(){
        return [
            KernelEvents::VIEW => ["checkUser",EventPriorities::PRE_WRITE],
        ];
    }
    public function checkUser(ViewEvent $event, string $method)
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        if ($user instanceof User && 
        !in_array($method,$this->methodNotAllowed,true)
        ) {
            // dd('hello');
            $this->authorizationChecker->Check($user,$method);
            $user->setUpdatedAt(new \DateTimeImmutable());
        }

    }
}