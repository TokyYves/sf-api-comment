<?php

namespace App\Events;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashPasswordUser implements EventSubscriberInterface
{
    private $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->userPasswordHasherInterface=$userPasswordHasherInterface;
    }
    public static function getSubscribedEvents(){
        return [
            KernelEvents::VIEW => ["hashPassword",EventPriorities::PRE_WRITE],
        ];
    }
    public function hashPassword(ViewEvent $event)
    {
        $user = $event->getControllerResult();

        if ($user instanceof User) {
            $hashPass = $this->userPasswordHasherInterface->hashPassword($user,$user->getPassword());
            $user->setPassword($hashPass);
        }
    }
}