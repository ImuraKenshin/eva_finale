<?php

namespace App\Controller;

use App\form\AdminType;
use App\Entity\Collaborateur;
use App\form\CollaborateurType;
use App\Repository\FonctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AffectationRepository;
use App\Repository\CollaborateurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CollaborateurController extends AbstractController
{
    #[Route('/personnel', name: 'app_collaborateur')]
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

    #[Route('/personnel/nouveau', name: 'add_collaborateur')]
    public function addCollaborateur(Request $request, EntityManagerInterface $em): Response
    {
        $collaborateur = new Collaborateur();

        $form = $this->createForm(CollaborateurType::class, $collaborateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $collaborateur->setRoles([]);
            $collaborateur->setEtat(true);
            $collaborateur->setAdmin(false);
            $collaborateur->setPassword("");
            $em->persist($collaborateur);
            $em->flush();
            
            return $this->redirectToRoute("app_collaborateur");
        }

        return $this->render('formulaire/addCollaborateur.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/personnel/modification/{id}', name: 'edit_collaborateur')]
    public function editCollaborateur(Collaborateur $collaborateur, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(CollaborateurType::class, $collaborateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            
            return $this->redirectToRoute("detail_collaborateur", ['id' => $collaborateur->getId()] );
        }

        return $this->render('formulaire/editCollaborateur.html.twig', [
            'form' => $form->createView(),
            'collaborateur' => $collaborateur,
        ]);
    }

    #[Route('/personnel/admin/{id}', name: 'edit_admin')]
    public function editAdmin(Collaborateur $collaborateur, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(AdminType::class, $collaborateur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $collaborateur->setRoles(["ROLE_USER","ROLE_DIRECTEUR"]);
            $em->flush();
            
            return $this->redirectToRoute("detail_collaborateur", ['id' => $collaborateur->getId()] );
        }

        return $this->render('formulaire/editAdmin.html.twig', [
            'form' => $form,
            'collaborateur' => $collaborateur,
        ]);
    }

    #[Route('/personnel/admin/retrait/{id}', name: 'retrait_admin')]
    public function retraitAdmin(Collaborateur $collaborateur, EntityManagerInterface $em): Response
    {
        $collaborateur->setAdmin(false);
        $collaborateur->setPassword("");
        $em->flush();

        return $this->redirectToRoute("detail_collaborateur", ['id' => $collaborateur->getId()] );
    }

    #[Route('/personnel/admin/fin/contrat/{id}', name: 'fin_contrat')]
    public function finContrat(Collaborateur $collaborateur, EntityManagerInterface $em): Response
    {
        $collaborateur->setEtat(false);
        $em->flush();

        return $this->redirectToRoute("detail_collaborateur", ['id' => $collaborateur->getId()] );
    }

    #[Route('/personnel/admin/ouvrir/contrat/{id}', name: 'ouvrir_contrat')]
    public function ouvrirContrat(Collaborateur $collaborateur, EntityManagerInterface $em): Response
    {
        $collaborateur->setEtat(true);
        $em->flush();

        return $this->redirectToRoute("detail_collaborateur", ['id' => $collaborateur->getId()] );
    }

    #[Route('/personnel/non/affecter', name: 'collaborateur_non_affecter')]
    public function collaborateurNonAffecter(CollaborateurRepository $CollaborateurRepository): Response
    {
        $liste = [];

        $collaborateurs = $CollaborateurRepository->listAllActif();

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

    #[Route('/personnel/detail/{id}', name: 'detail_collaborateur')]
    public function detailCollaborateur(AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository, Collaborateur $collaborateur): Response
    {
        $affectations = $AffectationRepository->affectationCollaborateur($collaborateur);

        $liste = $affectations;
        
        usort($liste, function($a, $b) {
            return $b->getId() <=> $a->getId();
        });

        if (empty($liste)) {
            $derniereAffectation = "";
        }else{
            $derniereAffectation = $liste[0];
        }
        

        $debuts = $AffectationRepository->dateCollaborateur($collaborateur);
        $postes = $FonctionRepository->ListeAll();
        return $this->render('collaborateur/detailCollab.html.twig', [
            'collaborateur' => $collaborateur,
            'affectations' => $affectations,
            'debuts' => $debuts,
            'postes' => $postes,
            'last' => $derniereAffectation,
        ]);
    }

    #[Route('/personnel/detail/filtre/poste/{id}', name: 'filtre_collaborateur_poste')]
    public function filtrePosteCollaborateur(Request $request, AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository, Collaborateur $collaborateur): Response
    {
        
        if($request->request->get("filtre") == "All"){
            return $this->redirectToRoute("detail_collaborateur", ['id' => $collaborateur->getId()] );
        }
        else{
            $poste = $request->request->get("filtre");
            $affectations = $AffectationRepository->filtreCollaborateurPoste($collaborateur, $poste);
            $liste = $AffectationRepository->affectationCollaborateur($collaborateur);
        
        usort($liste, function($a, $b) {
            return $b->getId() <=> $a->getId();
        });

        if (empty($liste)) {
            $derniereAffectation = "";
        }else{
            $derniereAffectation = $liste[0];
        }
        }

        $debuts = $AffectationRepository->dateCollaborateur($collaborateur);
        $postes = $FonctionRepository->ListeAll();

        return $this->render('collaborateur/detailCollab.html.twig', [
            'collaborateur' => $collaborateur,
            'affectations' => $affectations,
            'debuts' => $debuts,
            'postes' => $postes,
            'last' => $derniereAffectation,
        ]);
    }

    #[Route('/personnel/detail/filtre/debut/{id}', name: 'filtre_collaborateur_debut')]
    public function filtreDateCollaborateur(Request $request, AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository, Collaborateur $collaborateur): Response
    {
        if($request->request->get("filtre") == "All"){
            return $this->redirectToRoute("detail_collaborateur", ['id' => $collaborateur->getId()] );
        }
        else{
            $debut = $request->request->get("filtre");
            $affectations = $AffectationRepository->filtreCollaborateurDebut($collaborateur, $debut);

            $liste = $AffectationRepository->affectationCollaborateur($collaborateur);
        
        usort($liste, function($a, $b) {
            return $b->getId() <=> $a->getId();
        });

        if (empty($liste)) {
            $derniereAffectation = "";
        }else{
            $derniereAffectation = $liste[0];
        }
        }

        $debuts = $AffectationRepository->dateCollaborateur($collaborateur);
        $postes = $FonctionRepository->ListeAll();
        return $this->render('collaborateur/detailCollab.html.twig', [
            'collaborateur' => $collaborateur,
            'affectations' => $affectations,
            'debuts' => $debuts,
            'postes' => $postes,
            'last' => $derniereAffectation,
        ]);
    }
}
