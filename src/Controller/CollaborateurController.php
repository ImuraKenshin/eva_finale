<?php

namespace App\Controller;

use App\Repository\CollaborateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CollaborateurController extends AbstractController
{
    #[Route('/gestion/personnel', name: 'app_collaborateur')]
    public function index(Request $request,CollaborateurRepository $CollaborateurRepository): Response
    {
        if ($request->isMethod("POST")) {
            $search = $request->request->get("search");
            $collaborateurs = $CollaborateurRepository->searchCollaborateur($search);
        }
        else {
            $collaborateurs = $CollaborateurRepository->listAll();
        }

        return $this->render('collaborateur/listeCollab.html.twig', [
            'collaborateurs' => $collaborateurs,
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
