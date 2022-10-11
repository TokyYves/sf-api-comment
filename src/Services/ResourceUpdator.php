<?php

namespace App\Services;

use App\Authorization\AuthenticationCheckerInterface as AuthCheck;
use App\Authorization\ResourceCheckInterface as ResCheck;
use App\Entity\User;
use App\Services\Interface\ResourceUpdatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ResourceUpdator implements ResourceUpdatorInterface
{
    private $methodAllowed = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE
    ];
    private AuthCheck $authCheck;
    private ResCheck $resChecker;
    
    public function __construct(
         AuthCheck $authCheck,
         ResCheck $resChecker
    ) {
        $this->authCheck = $authCheck;
        $this->resChecker = $resChecker;
    }

    public function process(string $method, User $user): bool
    {

        if (in_array($method,$this->methodAllowed,true)) {
            $this->authCheck->isAuthenticated();
            $this->resChecker->canAccess($user->getId());
            return true;
        }
        return false;
    }
}
