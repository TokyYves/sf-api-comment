<?php

namespace App\Events;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Post;
use App\Entity\User;
use App\Services\Interface\ResourceUpdatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResourceUpdatorSubscriber implements EventSubscriberInterface
{

    private ResourceUpdatorInterface $resourceUpdatorInterface;

    public function __construct(ResourceUpdatorInterface $resourceUpdatorInterface)
    {
        $this->resourceUpdatorInterface = $resourceUpdatorInterface;
    }
    public static function getSubscribedEvents(){
        return [
            KernelEvents::VIEW => ["checkUser",EventPriorities::PRE_WRITE],
        ];
    }
    public function checkUser(ViewEvent $event)
    {
        $object = $event->getControllerResult();
        if ($object instanceof User || $object instanceof Post) {
            $user = $object instanceof User ? $object : $object->getAuthor();

            $canProcess = $this->resourceUpdatorInterface->process($event->getRequest()->getMethod(),$user);

            if ($canProcess) {
                $user->setUpdatedAt(new \DateTimeImmutable());
            }
        }

    }
}