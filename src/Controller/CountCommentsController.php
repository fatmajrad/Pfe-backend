<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;

class CountCommentsController extends AbstractController

{
  protected $commentaireRepository;
   public function __construct( CommentaireRepository  $commentaireRepository){  
     $this->commentaireRepository=$commentaireRepository;
   }

   public function __invoke( Request $request): int {
       $idUser=$request->get('idUser');
       $idConnaissance=$request->get('idConnaissance');
       $idReponse=$request->get('idReponse');
       return $this->commentaireRepository->findCommentByUser($idUser,$idConnaissance,$idReponse);
   }
}
