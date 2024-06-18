<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    #[Route('/registration', methods: ['GET','POST'])]
    public function index(UserPasswordHasherInterface $passwordHasher, Request $request, UserRepository $userRepo, EntityManagerInterface $em): Response
    {
        if($request->isMethod('POST')) {

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            if($password == $repassword){
                if(count($userRepo->findBy(['username' => $username])) < 1 && count($userRepo->findBy(['email' => $email])) < 1) {
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
                    try {
                        $em->persist($user);
                        $em->flush();
                    }catch (\Exception $e) {
                        return $this->render('registration/index.html.twig', ['errorMsg' => [$e]]);
                    }
                    return $this->render("home/index.html.twig",['msg' => 'Account create']);

                }else{
                    $errorMsg = [];
                    if(count($userRepo->findBy(['username' => $username])) > 1){
                        $errorMsg[] = 'Username already exists';
                    }
                    if(count($userRepo->findBy(['email' => $email])) > 1){
                        $errorMsg[] = 'Email already exists';
                    }
                    return $this->render('registration/index.html.twig', ['errorMsg' => $errorMsg]);
                }
            }
            return $this->render('registration/index.html.twig', ['errorMsg' => ['password error']]);
        }
        elseif($request->isMethod('GET')) {
            return $this->render("registration/index.html.twig");
        }
        else{
            return $this->render("registration/index.html.twig");
        }
    }
}
