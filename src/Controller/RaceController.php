<?php

namespace App\Controller;

use App\Entity\Race;
use App\Form\RaceType;
use App\Repository\RaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RaceController extends AbstractController
{
    #[Route('/race', name: 'race_index')]
    public function index(RaceRepository $raceRepo): Response
    {
        // $races = [
        //     [
        //         'picture' => "https://images.unsplash.com/photo-1498581444814-7e44d2fbe0e2?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTZ8fHRyYWlsfGVufDB8MHwwfHx8MA%3D%3D",
        //         'name' => "Courses des blaireaux",
        //         'type' => 'Trail',
        //         'kilometer' => 42,
        //         'denivele' => 3200,
        //         'date' => '01-02-2025',
        //         'city' => 'MesCouilles-En-vadrouille',
        //         'id'=> 1
        //     ],
        //     [
        //         'picture' => "https://images.unsplash.com/photo-1551927336-09d50efd69cd?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTV8fG1hcmF0aG9ufGVufDB8MHwwfHx8MA%3D%3D",
        //         'name' => "Courses des blaireaux",
        //         'type' => 'Route',
        //         'kilometer' => 42,
        //         'denivele' => 230,
        //         'date' => '05-02-2025',
        //         'city' => 'Pederaste',
        //         'id'=> 2
        //     ]
        //     ];
        $races = $raceRepo->findAll();


        return $this->render('race/index.html.twig', [
            'races' => $races,
        ]);
    }

    #[Route('/race/show/{id}', name: 'race_show')]
    public function showRace(RaceRepository $raceRepo, ?int $id)
    {  
        $race = $raceRepo->find($id);

        return $this->render('race/show.html.twig', [
            'race'=>$race
        ]);
    }
    #[Route('/race/new', name: 'race_new')]
    public function addRace(Request $request, EntityManagerInterface $em)
    {
        $race = new Race();
        $formRace = $this->createForm(RaceType::class, $race);
        $formRace->handleRequest($request);

        if($formRace->isSubmitted() && $formRace->isValid())
        {
            $race->setPicture("https://images.unsplash.com/photo-1571008887538-b36bb32f4571?w=800&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Nnx8bWFyYXRob258ZW58MHwwfDB8fHww");
            $em->persist($race);
            $em->flush();
            return $this->redirectToRoute('race_index');
        }
        return $this->render('race/new.html.twig', [
            'form' => $formRace->createView()
        ]);
    }
    // #[Route('race/edit/{id}', name: 'race_edit')]
}
