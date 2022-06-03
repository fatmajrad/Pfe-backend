<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VerifemailAdressController extends AbstractController
{
   
    public  function __invoke(User $data,MailerInterface  $mailer):User
    {   
        $email = (new Email())
            ->from('sharevioo@gmail.com')
            ->to($data->getEmail())
            ->subject('Reset Password')
            ->text("Verification de compte done:");
        $mailer->send($email);
        return $data;
    }
}
