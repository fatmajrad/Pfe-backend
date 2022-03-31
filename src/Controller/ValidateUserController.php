<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Validator\Constraints\DateTimeI;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class ValidateUserController extends AbstractController

{



    public  function __invoke(User $data,MailerInterface  $mailer):User
    {
        $data->setStatutValidation(true);
        $data->setRoles(["EDITOR_ROLE"]);
        $data->setValidatedAt(new \DateTimeImmutable('now'));
        $email = (new Email())
            ->from('sharevioo@gmail.com')
            ->to($data->getEmail())
            ->subject('Inscription à viewry')
            ->text("Votre demande d'inscription à ete accepté vous pouvez maintenant vous connecter à votre compte");
        $mailer->send($email);
        return $data;
    }


}

  

