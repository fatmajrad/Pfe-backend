<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Question;

class AddQuestionController extends AbstractController
{
  
    public function _invoke(Question $data )
    {
        
    }
}
