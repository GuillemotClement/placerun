<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UUserController extends AbstractController
{
    #[Route('/user', name: 'user_index')]
    public function index(): Response
    {
        return $this->render('u_user/index.html.twig');
    }
}
