<?php 

namespace App\Services\Interface;

use App\Entity\User;

interface ResourceUpdatorInterface 
{
    public function process(string $method , User $user);
}