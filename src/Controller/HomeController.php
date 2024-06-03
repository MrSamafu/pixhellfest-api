<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
    #[Route('/createAccount', name: 'createAccount', methods: ['GET','POST'])]
    public function createAccount(Request $request): Response
    {

        if($request->isMethod('POST')) {

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $repassword = $_POST['repassword'];
            $userRepo = New UserRepository();

            if($password == $repassword){
                if(count($userRepo->findBy(['username' => $username])) < 1){
                    dd('gg');
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
