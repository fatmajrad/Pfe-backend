<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
class ResetPasswprdController extends AbstractController
{
   
    private $passwordHasher;
    private $_entityManager;
    private $userRepository;
    
    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager,UserRepository $userRepository){
        $this->passwordHasher = $passwordHasher;
        $this->_entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }
       
    public function __invoke( User $data) {
       $encodedPassword=  $this->passwordHasher->hashPassword(
            $data,
            $data->getPassword()
        );
        $data->setPassword($encodedPassword);
        return $this->userRepository->updateUserPassword($data->getPassword(),$data->getId());
        }

      
    }

