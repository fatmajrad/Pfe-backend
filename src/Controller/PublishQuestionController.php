<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use app\Entity\Question;

class PublishQuestionController extends AbstractController
{
    public  function __invoke(Question $data):Question
    {
        $data->setStatut("onHold");
        return $data;
    }
}
