<?php

namespace App\Controller;

use App\Repository\VoteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RatedConnaissancesController extends AbstractController
{
    protected $voteRepository;
    
    public function __construct( VoteRepository  $voteRepository){  
        $this->voteRepository=$voteRepository;
    }
 
    public function __invoke( Request $request) {
        
        return $this->voteRepository->getRatedConnaissances();
    }
}
