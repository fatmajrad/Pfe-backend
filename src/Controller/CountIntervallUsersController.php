<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountIntervallUsersController extends AbstractController
{
    protected $userRepository;
    
    public function __construct( UserRepository  $userRepository){  
        $this->userRepository=$userRepository;
    }
 
    public function __invoke( Request $request): array {
        $statut=$request->get('statut',[]);
        $minDate=$request->get('minDate',[]);
        $maxDate=$request->get('maxDate',[]);
        return $this->userRepository->countIntervallUsers($statut,$minDate,$maxDate);
    }
}
