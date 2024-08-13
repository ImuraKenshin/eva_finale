<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CollaborateurController extends AbstractController
{
    #[Route('/gestion/personnel', name: 'app_collaborateur')]
    public function index(): Response
    {
        return $this->render('collaborateur/index.html.twig', [
            'controller_name' => 'CollaborateurController',
        ]);
    }

    #[Route('/nouveau/personnel', name: 'add_collaborateur')]
    public function addCollaborateur(): Response
    {
        return $this->render('collaborateur/index.html.twig', [
            'controller_name' => 'CollaborateurController',
        ]);
    }

    #[Route('/personnel/non/affecter', name: 'collaborateur_non_affecter')]
    public function collaborateurNonAffecter(): Response
    {
        return $this->render('collaborateur/index.html.twig', [
            'controller_name' => 'CollaborateurController',
        ]);
    }

    #[Route('/detail/personnel/{id}', name: 'detail_collaborateur')]
    public function detailCollaborateur(): Response
    {
        return $this->render('collaborateur/index.html.twig', [
            'controller_name' => 'CollaborateurController',
        ]);
    }
}
