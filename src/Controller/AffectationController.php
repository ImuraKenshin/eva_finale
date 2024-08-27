<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\Affectation;
use App\Entity\Collaborateur;
use App\form\AffectationType;
use App\Repository\FonctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AffectationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AffectationController extends AbstractController
{
    #[Route('/affectation/gestion', name: 'app_affectation')]
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

    #[Route('/affectation/gestion/filtre/poste', name: 'filtre_poste_affectation')]
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

    #[Route('/affectation/gestion/filtre/debut', name: 'filtre_debut_affectation')]
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

    #[Route('/affectation/gestion/filtre/fin', name: 'filtre_fin_affectation')]
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
            'restaurant' => $restaurant,
        ]);
    }

    #[Route('/affectation/formulaire/collaborateur/{id}', name: 'affectation_collaborateur')]
    public function affectationCollaborateur(Collaborateur $collaborateur,Request $request, EntityManagerInterface $em): Response
    {
        $affectation = new Affectation();
        
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $affectation->setCollaborateur($collaborateur);
            $em->persist($affectation);
            $em->flush();
            
            return $this->redirectToRoute("detail_collaborateur", ['id' => $collaborateur->getId()] );
        }

        return $this->render('formulaire/addAffectation.html.twig', [
            'form' => $form,
            'collaborateur' => $collaborateur,
        ]);

    }

    #[Route('/affectation/fin/affectation/{id}', name: 'fin_affectation_collaborateur')]
    public function finAffectationCollaborateur(Affectation $affectation, EntityManagerInterface $em): Response
    {

        $jour = new \DateTime();

        $affectation->setFin($jour);
        $em->flush();
        
        return $this->redirectToRoute("detail_collaborateur", ['id' => $affectation->getCollaborateur()->getId()] );

    }
}
