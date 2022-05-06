<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VoteRepository;
use Symfony\Component\HttpFoundation\Request;


class CountVoteController extends AbstractController
{ 
    protected $voteRepository;
    
    public function __construct( VoteRepository  $voteRepository){  
        $this->voteRepository=$voteRepository;
    }
 
    public function __invoke( Request $request): int {
        //dump($idUser,$idConnaissance,$idReponse,$idQuestion,$typeVote);
        $idUser=$request->get('idUser');
        $idConnaissance=$request->get('idConnaissance');
        $idReponse=$request->get('idReponse');
        $idQuestion=$request->get('idQuestion');
        $typeVote=$request->get('typeVote');
        dump($idUser,$idConnaissance,$idReponse,$idQuestion,$typeVote);
        return $this->voteRepository->countVoteParam($idUser,$idConnaissance,$idReponse,$idQuestion,$typeVote);
    }
}
