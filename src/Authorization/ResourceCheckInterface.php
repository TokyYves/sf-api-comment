<?php 

namespace App\Authorization;


interface ResourceCheckInterface
{
    const MESSAGE_ERROR = "Vous ne pouvez pas acceder a ces ressources";

    public function canAccess(?int $id):void;
}