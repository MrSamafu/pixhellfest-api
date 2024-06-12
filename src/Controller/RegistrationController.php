<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/registration', methods: ['GET','POST'])]
    public function index(UserPasswordHasherInterface $passwordHasher, Request $request, UserRepository $userRepo): Response
    {
        if($request->isMethod('POST')) {

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            if($password == $repassword){
                if(count($userRepo->findBy(['username' => $username])) < 1){
                    // ... e.g. get the user data from a registration form
                    $user = new User();
                    $user->setEmail($email);
                    $user->setUsername($username);
                    $plaintextPassword = $password;

                    // hash the password (based on the security.yaml config for the $user class)
                    $hashedPassword = $passwordHasher->hashPassword(
                        $user,
                        $plaintextPassword
                    );
                    $user->setPassword($hashedPassword);
                    //ajouter l'envoie vers la bdd
                }
            }
            return $this->render('home/index.html.twig');
        }
        elseif($request->isMethod('GET')) {
            return $this->render("home/createAccount.html.twig");
        }
        else{
            return $this->render("home/createAccount.html.twig");
        }
    }
}
