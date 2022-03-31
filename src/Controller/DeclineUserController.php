<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeclineUserController extends AbstractController
{
    public  function __invoke(User $data):User
    {
        $data->setStatutValidation(false);
        return $data;
    }
}
