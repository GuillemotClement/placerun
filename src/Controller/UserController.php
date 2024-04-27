<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Vma;
use App\Form\UserType;
use App\Form\VmaType;
use App\Service\RunningTool;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Repository\VmaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
  // Marche, pas, faudras la faire 
    #[Route('/user', name: 'user_index')]
    public function index(RunningTool $rt, UserRepository $userRepo, VmaRepository $vmaRepo): Response
    {
        $users = $userRepo->findAll();

        foreach ($users as $user)
        {
          $vmas = $vmaRepo->findBy(['user' => $user]);
          foreach($vmas as $vma){
            $user->addVma($vma);
          }
        }
        return $this->render('user/index.html.twig',[
            'users' => $users
        ]);
    }

    #[Route('/user/new', name: 'user_new')]
    #[Route('/user/edit/{id}', name: 'user_edit')]
    public function editUser(Request $request, EntityManagerInterface $em, RunningTool $rt, ?int $id, UserRepository $userRepo)
    {
        if($id){
          $user = $userRepo->find($id);
        } else{
          $user = new User();
        }

        $formUser = $this->createForm(UserType::class, $user);
        
        $formUser->handleRequest($request);

        if($formUser->isSubmitted() && $formUser->isValid()){
          if(!$id){
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setFcm($rt->MaxHeartRate($user->getAge()));
            $em->persist($user);
          }
          $em->flush();
          return $this->redirectToRoute('user_index');
        }
        // $user = new User();
        // $formUser = $this->createForm(UserType::class, $user);
        // $formUser->handleRequest($request);

        // if($formUser->isSubmitted() && $formUser->isValid())
        // {
        //     $user->setCreatedAt(new \DateTimeImmutable());
        //     $user->setFcm($rt->MaxHeartRate($user->getAge()));
        //     $em->persist($user);
        //     $em->flush();
        //     return $this->redirectToRoute('user_index');
        // }

        return $this->render('user/edit.html.twig',[
            'form'=>$formUser->createView()
        ]);
    }

    #[Route('/user/remove/{id}', name:'user_remove')]
    public function remove(EntityManagerInterface $em, ?int $id, UserRepository $userRepo)
    {
        $user = $userRepo->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('user_index');
    }

    #[Route('/user/{id}/addVma', name: 'user_add_vma')]
    public function addVma(Request $request, UserRepository $userRepo, EntityManagerInterface $em, ?int $id)
    {
      $user = $userRepo->find($id);
      $vma = new Vma();
      $formVma = $this->createForm(VmaType::class, $vma);
      $formVma->handleRequest($request);

      if($formVma->isSubmitted() && $formVma->isValid())
      {
        
        $vma->setUser($user);
        $vma->setPerfDate( new \DateTime());

        $em->persist($vma);
        $em->flush();

        return $this->redirectToRoute('user_index');
      }

      return $this->render('user/editVma.html.twig', [
        'form' => $formVma->createView()
      ]);
    }
}
