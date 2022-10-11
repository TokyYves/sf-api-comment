<?php 

namespace App\Authorization;


interface AuthenticationCheckerInterface 
{
    const MESSAGE_ERROR = "Vous n'ete pas athentifier";

    public function isAuthenticated();
}