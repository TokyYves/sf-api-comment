<?php 

namespace App\Authorization;

use App\Authorization\AuthenticationCheckerInterface as AuthCheck;
use App\Entity\User;
use App\Exceptions\AuthentificationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationChecker implements AuthCheck
{
    private ?User $user;
    
    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }
    public function isAuthenticated(): void{
        if ( $this->user === null) {
            throw new AuthentificationException(
                Response::HTTP_UNAUTHORIZED,
                self::MESSAGE_ERROR
            );
        }
    }
}