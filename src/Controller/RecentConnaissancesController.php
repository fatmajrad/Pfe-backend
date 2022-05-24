<?php

namespace App\Controller;

use App\Repository\ConnaissanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecentConnaissancesController extends AbstractController
{
    protected $questionRepository;
    
    public function __construct( ConnaissanceRepository  $questionRepository){  
        $this->questionRepository=$questionRepository;
    }
 
    public function __invoke(): array {
        return $this->questionRepository->getRecentConnaissances();
    }
}
