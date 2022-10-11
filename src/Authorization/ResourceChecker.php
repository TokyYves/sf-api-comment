<?php

namespace App\Authorization;

use App\Authorization\ResourceCheckInterface as CheckResource;
use App\Entity\User;
use App\Exceptions\ResourceAccessException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class ResourceChecker implements CheckResource
{

    private ?User $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function canAccess(?int $id): void
    {
        if ( $this->user->getId() !== $id) {
            throw new ResourceAccessException(
                Response::HTTP_UNAUTHORIZED,
                self::MESSAGE_ERROR
            );
        }
       
    }
}
