<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use App\Repository\VoteRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BestQuestionsController extends AbstractController
{
    protected $questionRepository;
    protected $voteRepository;
    
    public function __construct( QuestionRepository  $questionRepository, VoteRepository $voteRepository){  
        $this->questionRepository=$questionRepository;
        $this->voteRepository=$voteRepository;
    }
 
    public function __invoke( Request $request): array {
        dd($this->voteRepository->getRatedQuestions());
        return $this->voteRepository->getRatedQuestions();
    }
}
