<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetAllUsersController extends AbstractController
{
    protected $userRepository;
    
    public function __construct( UserRepository  $userRepository){  
        $this->userRepository=$userRepository;
    }
 
    public function __invoke( Request $request): array {
        return $this->userRepository->getAllUsers();
    }
}
