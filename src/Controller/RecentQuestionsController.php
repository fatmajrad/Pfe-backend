<?php

namespace App\Controller;


use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecentQuestionsController extends AbstractController
{ protected $questionRepository;
    
    public function __construct( QuestionRepository  $questionRepository){  
        $this->questionRepository=$questionRepository;
    }
 
    public function __invoke(): array {
        return $this->questionRepository->getRecentQuestions();
    }
}
