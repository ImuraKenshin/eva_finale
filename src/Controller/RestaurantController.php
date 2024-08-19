<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
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
        }
        else {
            $Restaurants = $RestaurantRepository->listAll();
        }
        return $this->render('restaurant/listeResto.html.twig', [
            'restaurants' => $Restaurants,
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
    public function detailRestaurant(): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'RestaurantController',
        ]);
    }
}
