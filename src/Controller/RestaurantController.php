<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\form\RestaurantType;
use App\Repository\FonctionRepository;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AffectationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RestaurantController extends AbstractController
{
    #[Route('/restaurant/gestion', name: 'app_restaurant')]
    public function index(Request $request, RestaurantRepository $RestaurantRepository): Response
    {


        if ($request->isMethod("POST")) {
            $search = $request->request->get("search");
            $Restaurants = $RestaurantRepository->searchRestaurant($search);
            $villes = $RestaurantRepository->listVille();
        }
        else {
            $Restaurants = $RestaurantRepository->listAll();
            $villes = $RestaurantRepository->listVille();
        }
        return $this->render('restaurant/listeResto.html.twig', [
            'restaurants' => $Restaurants,
            'villes' => $villes,
        ]);
    }

    #[Route('/restaurant/gestion/filtrer',methods: ['POST'], name: 'app_filtre_restaurant')]
    public function filtreVille(Request $request, RestaurantRepository $RestaurantRepository): Response
    {

        if($request->request->get("filtre") == "All"){
            return $this->redirectToRoute("app_restaurant");
        }
        else{
            $ville = $request->request->get("filtre");
            $Restaurants = $RestaurantRepository->searchRestaurant($ville);
        }
        
        
        $villes = $RestaurantRepository->listVille();



        return $this->render('restaurant/listeResto.html.twig', [
            'restaurants' => $Restaurants,
            'villes' => $villes,
        ]);
    }

    #[Route('/restaurant/gestion/creation', name: 'restaurant_creation')]
    public function creationRestaurant(Request $request, EntityManagerInterface $em): Response
    {
        $restaurant = new Restaurant();

        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($restaurant);
            $em->flush();
            
            return $this->redirectToRoute("app_restaurant");
        }

        return $this->render('formulaire/addRestaurant.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/restaurant/gestion/modification/{id}', name: 'restaurant_modif')]
    public function modifRestaurant(Restaurant $restaurant, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            
            return $this->redirectToRoute("detail_restaurant",['id' => $restaurant->getId()]);
        }

        return $this->render('formulaire/editRestaurant.html.twig', [
            'form' => $form->createView(),
            'restaurant' => $restaurant,
        ]);
    }

    #[Route('/restaurant/gestion/fermeture/{id}', name: 'restaurant_fermer')]
    public function fermerRestaurant(Restaurant $restaurant, EntityManagerInterface $em): Response
    {

        $restaurant->setEtat(false);
        $em->flush();
            
        return $this->redirectToRoute("detail_restaurant",['id' => $restaurant->getId()]);
    }

    #[Route('/restaurant/gestion/ouverture/{id}', name: 'restaurant_ouvrir')]
    public function ouvrirRestaurant(Restaurant $restaurant, EntityManagerInterface $em): Response
    {

        $restaurant->setEtat(true);
        $em->flush();
            
        return $this->redirectToRoute("detail_restaurant",['id' => $restaurant->getId()]);
    }

    #[Route('/restaurant/detail/{id}', name: 'detail_restaurant')]
    public function detailRestaurant(Restaurant $restaurant,AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository ): Response
    {

        $affectations = $AffectationRepository->affectationRestaurant($restaurant);
        $listePoste = $FonctionRepository->ListeAll();
        $listeDate = $AffectationRepository->listDate();

        return $this->render('restaurant/detailResto.html.twig', [
            'restaurant' => $restaurant,
            'affectations' => $affectations,
            'postes' => $listePoste,
            'dates' => $listeDate,
        ]);
    }

    #[Route('/restaurant/detail/filtre/poste/{id}', name: 'filtre_poste_restaurant')]
    public function filtrePosteRestaurant(Request $request, Restaurant $restaurant,AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository ): Response
    {

        if($request->request->get("filtre") == "All"){
            return $this->redirectToRoute("detail_restaurant",['id' => $restaurant->getId()]);
        }
        else{
            $poste = $request->request->get("filtre");
            $affectations = $AffectationRepository->filtreRestaurantPoste($restaurant,$poste);
        }

        $listePoste = $FonctionRepository->ListeAll();
        $listeDate = $AffectationRepository->listDate();
        

        return $this->render('restaurant/detailResto.html.twig', [
            'restaurant' => $restaurant,
            'affectations' => $affectations,
            'postes' => $listePoste,
            'dates' => $listeDate,
        ]);
    }

    #[Route('/restaurant/detail/filtre/debut/{id}', name: 'filtre_debut_restaurant')]
    public function filtreDetailRestaurant(Request $request, Restaurant $restaurant,AffectationRepository $AffectationRepository, FonctionRepository $FonctionRepository ): Response
    {

        if($request->request->get("filtre") == "All"){
            return $this->redirectToRoute("detail_restaurant",['id' => $restaurant->getId()]);
        }
        else{
            $debut = $request->request->get("filtre");
            $affectations = $AffectationRepository->filtreRestaurantDebut($restaurant,$debut);
        }
        $listePoste = $FonctionRepository->ListeAll();
        $listeDate = $AffectationRepository->listDate();

        return $this->render('restaurant/detailResto.html.twig', [
            'restaurant' => $restaurant,
            'affectations' => $affectations,
            'postes' => $listePoste,
            'dates' => $listeDate,
        ]);
    }
}
