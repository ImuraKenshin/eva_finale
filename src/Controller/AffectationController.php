<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\FonctionRepository;
use App\Repository\AffectationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AffectationController extends AbstractController
{
    #[Route('/gestion/affectation', name: 'app_affectation')]
    public function index(AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository): Response
    {
        $affectations = $AffectationRepository->ListAll();
        $postes = $FonctionRepository->ListeAll();
        $debuts = $AffectationRepository->listDebut();
        $fins = $AffectationRepository->listFin();

        return $this->render('affectation/listeAffect.html.twig', [
            'affectations' => $affectations,
            'postes' => $postes,
            'debuts' => $debuts,
            'fins' => $fins,
        ]);
    }

    #[Route('/gestion/affectation/filtre/poste', name: 'filtre_poste_affectation')]
    public function FiltrePoste(Request $request, AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository): Response
    {
        
        if($request->request->get("filtre") == "All"){
            return $this->redirectToRoute("app_affectation");
        }
        else{
            $poste = $request->request->get("filtre");
            $affectations = $AffectationRepository->filtrePoste($poste);
        }

        $postes = $FonctionRepository->ListeAll();
        $debuts = $AffectationRepository->listDebut();
        $fins = $AffectationRepository->listFin();

        return $this->render('affectation/listeAffect.html.twig', [
            'affectations' => $affectations,
            'postes' => $postes,
            'debuts' => $debuts,
            'fins' => $fins,
        ]);
    }

    #[Route('/gestion/affectation/filtre/debut', name: 'filtre_debut_affectation')]
    public function FiltreDebut(Request $request, AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository): Response
    {
        if($request->request->get("filtre") == "All"){
            return $this->redirectToRoute("app_affectation");
        }
        else{
            $debut = $request->request->get("filtre");
            $affectations = $AffectationRepository->filtreDateDebut($debut);
        }

        $postes = $FonctionRepository->ListeAll();
        $debuts = $AffectationRepository->listDebut();
        $fins = $AffectationRepository->listFin();

        return $this->render('affectation/listeAffect.html.twig', [
            'affectations' => $affectations,
            'postes' => $postes,
            'debuts' => $debuts,
            'fins' => $fins,
        ]);
    }

    #[Route('/gestion/affectation/filtre/fin', name: 'filtre_fin_affectation')]
    public function FiltreFin(Request $request, AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository): Response
    {
        if($request->request->get("filtre") == "All"){
            return $this->redirectToRoute("app_affectation");
        }
        else{
            $fin = $request->request->get("filtre");
            $affectations = $AffectationRepository->filtreDateFin($fin);
        }

        $postes = $FonctionRepository->ListeAll();
        $debuts = $AffectationRepository->listDebut();
        $fins = $AffectationRepository->listFin();

        return $this->render('affectation/listeAffect.html.twig', [
            'affectations' => $affectations,
            'postes' => $postes,
            'debuts' => $debuts,
            'fins' => $fins,
        ]);
    }

    #[Route('/affectation/restaurant/{id}', name: 'affectation_restaurant')]
    public function affectationDuRestaurant(Restaurant $restaurant, AffectationRepository $AffectationRepository): Response
    {
        $affectations = $AffectationRepository->affectationRestaurant($restaurant);

        return $this->render('affectation/historiqueResto.html.twig', [
            'affectations' => $affectations,
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
