<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckUserMailController extends AbstractController
{
    protected $questionRepository;
    
    
    public function __construct( QuestionRepository  $questionRepository){  
        $this->questionRepository=$questionRepository;
       
    }
 
    public function __invoke( Request $request): array {
        dd($request);
        return $this->questionRepository->getRatedQuestions();
    }
}
