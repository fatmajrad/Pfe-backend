<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class DeclineUserController extends AbstractController
{
    public  function __invoke(User $data,MailerInterface  $mailer):User
    {  
        $data->setStatut("invalide");
        $data->setValidatedAt(new \DateTime('now'));
        $email = (new Email())
        ->from('sharevioo@gmail.com')
        ->to($data->getEmail())
        ->subject(' viewry')
        ->text($data->getRemarque());
        $mailer->send($email);
        return $data;
        
    }
}
