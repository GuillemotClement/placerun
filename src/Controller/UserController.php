<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_index')]
    public function index(UserRepository $repoUser): Response
    {
        $users = [
            [
                'name' => 'Julie',
                'email' => 'julie@mail.com',
                'password'=> '123456',
                'vma' => "18",
                'age' => "25",
                'createdAt'=> "17-06-1995",
                'img' => 'https://randomuser.me/api/portraits/women/68.jpg'
            ],
            [
                'name' => 'Marc',
                'email' => 'marc@mail.com',
                'password'=> '123456',
                'vma' => "15",
                'age' => "29",
                'createdAt'=> "17-04-1995",
                'img' => 'https://randomuser.me/api/portraits/men/81.jpg'
            ]
            ];


        return $this->render('user/index.html.twig',[
            'users' => $users
        ]);
    }
}
