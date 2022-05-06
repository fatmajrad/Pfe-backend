<?php

namespace App\Controller;

use App\Repository\ConnaissanceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CountIntervallConnaissancesController extends AbstractController
{
    protected $connaissanceRepository;
    
    public function __construct( ConnaissanceRepository  $connaissanceRepository){  
        $this->connaissanceRepository=$connaissanceRepository;
    }
 
    public function __invoke( Request $request): array {
        $statut=$request->get('statut',[]);
        $minDate=$request->get('minDate',[]);
        $maxDate=$request->get('maxDate',[]);
        return $this->connaissanceRepository->countIntervallConnaissances($statut,$minDate,$maxDate);
    }
}
