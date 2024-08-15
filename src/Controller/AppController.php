<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{

    #[Route('/', name: 'app_app')]
    public function redirectionAccueil(): Response
    {
        return $this->redirectToRoute("app_accueil");
    }

    #[Route('/accueil', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('app/accueil.html.twig', [
        ]);
    }
}
