<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CommentaireRepository;


class CountCommentsController extends AbstractController

{
   private CommentaireRepository $commentaireRepository ; 
   

   public function __construct( CommentaireRepository  $commentaireRepository){  
    
     $this->$commentaireRepository= $commentaireRepository;
   }

   public function __invoke(): int {
       return $this->commentaireRepository->count([]);
   }
}
