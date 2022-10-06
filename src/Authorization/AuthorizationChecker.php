<?php 

namespace App\Authorization;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Security;

class AuthorizationChecker 
{
    private $methodAllowed = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE
    ];

    private ?User $user;
    
    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function Check(User $user,string $method): void
    {
        $this->isAuthenticated();
        if (
            $this->isMethodAllowed($method) &&
            $user->getId() !== $this->user->getId()
        ) {
            $message = "You are not authorized";
            throw new UnauthorizedHttpException($message,$message);
        }
    }

    public function isAuthenticated(): void
    {
        if (null === $this->user) {
            $message = "You are not Authenticated";
            throw new UnauthorizedHttpException($message,$message);
        }
    }
    public function isMethodAllowed(string $method): bool
    {
        return in_array($method, $this->methodAllowed,true);
    }
}