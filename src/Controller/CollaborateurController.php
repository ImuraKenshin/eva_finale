<?php

namespace App\Controller;

use App\Entity\Collaborateur;
use App\Repository\FonctionRepository;
use App\Repository\AffectationRepository;
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
    public function collaborateurNonAffecter(CollaborateurRepository $CollaborateurRepository): Response
    {
        $liste = [];

        $collaborateurs = $CollaborateurRepository->listAll();

        foreach ($collaborateurs as $collaborateur) {
            // je récupère les affectations du collaborateur et les transforme en une liste
            $affectations = $collaborateur->getAffectations()->toArray();
    
            if (empty($affectations)) {
                // j'ajoute le collaborateur à la liste s'il n'a jamais eu d'affectation
                $liste[] = $collaborateur;
                continue;
            }
    
            // je tri mes affectations pour être sûr de toujours avoir la dernière en date
            usort($affectations, function($a, $b) {
                return $b->getId() <=> $a->getId();
            });
    
            // je récupère la dernière affectation
            $derniereAffectation = $affectations[0];

            // j'ajoute à la liste si la dernière affectation est sans date de fin
            if ($derniereAffectation->getFin() != "") {
                $liste[] = $collaborateur;
            }
        }
        



        return $this->render('collaborateur/listeNonAffecter.html.twig', [
            'collaborateurs' => $liste,
        ]);
    }

    #[Route('/detail/personnel/{id}', name: 'detail_collaborateur')]
    public function detailCollaborateur(AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository, Collaborateur $collaborateur): Response
    {
        $affectations = $AffectationRepository->affectationCollaborateur($collaborateur);

        $debuts = $AffectationRepository->dateCollaborateur($collaborateur);
        $postes = $FonctionRepository->ListeAll();
        return $this->render('collaborateur/detailCollab.html.twig', [
            'collaborateur' => $collaborateur,
            'affectations' => $affectations,
            'debuts' => $debuts,
            'postes' => $postes,
        ]);
    }

    #[Route('/detail/filtre/poste/personnel/{id}', name: 'filtre_collaborateur_poste')]
    public function filtrePosteCollaborateur(Request $request, AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository, Collaborateur $collaborateur): Response
    {
        
        if($request->request->get("filtre") == "All"){
            return $this->redirectToRoute("detail_collaborateur", ['id' => $collaborateur->getId()] );
        }
        else{
            $poste = $request->request->get("filtre");
            $affectations = $AffectationRepository->filtreCollaborateurPoste($collaborateur, $poste);
        }

        $debuts = $AffectationRepository->dateCollaborateur($collaborateur);
        $postes = $FonctionRepository->ListeAll();

        return $this->render('collaborateur/detailCollab.html.twig', [
            'collaborateur' => $collaborateur,
            'affectations' => $affectations,
            'debuts' => $debuts,
            'postes' => $postes,
        ]);
    }

    #[Route('/detail/filtre/debut/personnel/{id}', name: 'filtre_collaborateur_debut')]
    public function filtreDateCollaborateur(Request $request, AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository, Collaborateur $collaborateur): Response
    {
        if($request->request->get("filtre") == "All"){
            return $this->redirectToRoute("detail_collaborateur", ['id' => $collaborateur->getId()] );
        }
        else{
            $debut = $request->request->get("filtre");
            $affectations = $AffectationRepository->filtreCollaborateurDebut($collaborateur, $debut);
        }

        $debuts = $AffectationRepository->dateCollaborateur($collaborateur);
        $postes = $FonctionRepository->ListeAll();
        return $this->render('collaborateur/detailCollab.html.twig', [
            'collaborateur' => $collaborateur,
            'affectations' => $affectations,
            'debuts' => $debuts,
            'postes' => $postes,
        ]);
    }
}
