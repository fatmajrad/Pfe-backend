<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MeController extends AbstractController{

    private $security;

    public function __construct(Security $security){
      $this->security = $security;
    }
    
    public function __invoke(Request $request)
    {
      $user =$this->security->getUser();
      return $user;
         
    }
}