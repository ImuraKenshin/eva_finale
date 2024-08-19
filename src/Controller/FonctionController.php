<?php

namespace App\Controller;

use App\Repository\FonctionRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FonctionController extends AbstractController
{
    #[Route('/gestion/fonction', name: 'app_fonction')]
    public function index(FonctionRepository $FonctionRepository): Response
    {
        $fonctions = $FonctionRepository->ListeAll();

        return $this->render('fonction/listeFonction.html.twig', [
            'fonctions' => $fonctions,
        ]);
    }

    #[Route('/fonction/edition/{id}', name: 'fonction_edition')]
    public function editionFonction(): Response
    {
        return $this->render('fonction/index.html.twig', [
            'controller_name' => 'FonctionController',
        ]);
    }

    #[Route('/fonction/creation', name: 'fonction_creation')]
    public function creationFonction(): Response
    {
        return $this->render('fonction/index.html.twig', [
            'controller_name' => 'FonctionController',
        ]);
    }
}
