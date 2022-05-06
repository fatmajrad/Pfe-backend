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
        $email = (new Email())
        ->from('sharevioo@gmail.com')
        ->to($data->getEmail())
        ->subject('Inscription à viewry')
        ->text($data->getRemarque()+"helloooooooooooo");
        $mailer->send($email);
        return $data;
        
    }
}
