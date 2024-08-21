<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\FonctionRepository;
use App\Repository\RestaurantRepository;
use App\Repository\AffectationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RestaurantController extends AbstractController
{
    #[Route('/gestion/restaurant', name: 'app_restaurant')]
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

    #[Route('/gestion/filtrer/restaurant',methods: ['POST'], name: 'app_filtre_restaurant')]
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

    #[Route('/restaurant/creation', name: 'restaurant_creation')]
    public function creationRestaurant(): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'RestaurantController',
        ]);
    }

    #[Route('/detail/restaurant/{id}', name: 'detail_restaurant')]
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

    #[Route('/detail/filtre/poste/restaurant/{id}', name: 'filtre_poste_restaurant')]
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

    #[Route('/detail/filtre/debut/restaurant/{id}', name: 'filtre_debut_restaurant')]
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
