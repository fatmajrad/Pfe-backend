<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;


class RespondToReclamationController extends AbstractController
{
    public  function __invoke(Reclamation $data,MailerInterface  $mailer):Reclamation
    {   $answer = $data->getAnswer();
        $data->setStatut("Responded");
        $data->setAnswer($answer);
        $data->setAnswredAt(new \DateTime('now'));
        $email = (new Email())
            ->from('sharevioo@gmail.com')
            ->to($data->getUserEmail())
            ->subject('Inscription à viewry')
            ->text($answer);
            $mailer->send($email);
            return $data;
        }
}
