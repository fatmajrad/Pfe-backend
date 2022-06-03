<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeclineUserController extends AbstractController
{
    private $userRepository;
    
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
       }
    
    public  function __invoke(User $data,MailerInterface  $mailer):User
    {  
       $email = (new Email())
        ->from('sharevioo@gmail.com')
        ->to($data->getEmail())
        ->subject('Inscription à viewry')
        ->text("Votre demande d'inscription à Viewry a été refusé.Pour la raison suivante:",$data->getRemarque());
        $mailer->send($email);
        $statut ="invalide";
        return $this->userRepository->declineUser($data->getId(),$statut);
        
        
    }
}
