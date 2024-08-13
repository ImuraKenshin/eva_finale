<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AffectationController extends AbstractController
{
    #[Route('/liste/affectation', name: 'app_affectation')]
    public function index(): Response
    {
        return $this->render('affectation/index.html.twig', [
            'controller_name' => 'AffectationController',
        ]);
    }

    #[Route('/affectation/restaurant/{id}', name: 'affectation_restaurant')]
    public function affectationRestaurant(): Response
    {
        return $this->render('affectation/index.html.twig', [
            'controller_name' => 'AffectationController',
        ]);
    }

    #[Route('/formulaire/affectation/collaborateur/{id}', name: 'affectation_collaborateur')]
    public function affectationCollaborateur(): Response
    {
        return $this->render('affectation/index.html.twig', [
            'controller_name' => 'AffectationController',
        ]);
    }

    #[Route('/formulaire/affectation/collaborateur/restaurant/{id}', name: 'affectation_collaborateur_restaurant')]
    public function affectationCollaborateurRestaurant(): Response
    {
        return $this->render('affectation/index.html.twig', [
            'controller_name' => 'AffectationController',
        ]);
    }
}
