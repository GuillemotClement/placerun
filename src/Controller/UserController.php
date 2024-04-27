<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Service\RunningTool;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user_index')]
    public function index(RunningTool $rt, UserRepository $userRepo): Response
    {
        // $users = [
        //     [
        //         'name' => 'Julie',
        //         'email' => 'julie@mail.com',
        //         'password'=> '123456',
        //         'vma' => "18",
        //         'age' => "25",
        //         'createdAt'=> "17-06-1995",
        //         'img' => 'https://randomuser.me/api/portraits/women/68.jpg',
        //         'fcm' => '191'
        //     ],
        //     [
        //         'name' => 'Marc',
        //         'email' => 'marc@mail.com',
        //         'password'=> '123456',
        //         'vma' => "15",
        //         'age' => "29",
        //         'createdAt'=> "17-04-1995",
        //         'img' => 'https://randomuser.me/api/portraits/men/81.jpg',
        //         'fcm' => '186'
        //     ]
        //     ];

        $users = $userRepo->findAll();

        return $this->render('user/index.html.twig',[
            'users' => $users
        ]);
    }

    #[Route('/user/new', name: 'user_new')]
    public function editUser(Request $request, EntityManagerInterface $em)
    {
        $user = new User();
        $formUser = $this->createForm(UserType::class, $user);
        $formUser->handleRequest($request);

        if($formUser->isSubmitted() && $formUser->isValid())
        {
            $user->setCreatedAt(new \DateTimeImmutable());
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig',[
            'form'=>$formUser->createView()
        ]);
    }
}
