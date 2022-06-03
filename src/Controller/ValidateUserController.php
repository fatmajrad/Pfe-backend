<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTimeI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class ValidateUserController extends AbstractController

{   private $userRepository;
    
    public function __construct(UserRepository $userRepository){
    $this->userRepository = $userRepository;
   }

    public  function __invoke(User $data,MailerInterface  $mailer):User
    {   $email = (new Email())
        ->from('sharevioo@gmail.com')
        ->to($data->getEmail())
        ->subject('Inscription à viewry')
        ->text("Votre demande d'inscription à Viewry a été accepté.
          Vous pouvez acceder à votre compte maintenant");
        $mailer->send($email);
        $statut ="valide";
        $role='["ROLE_EDITOR"]';
        return $this->userRepository->validateUser($data->getId(),$statut,$role);
        
    }
}

  

