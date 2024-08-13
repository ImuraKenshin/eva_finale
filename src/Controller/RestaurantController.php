<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RestaurantController extends AbstractController
{
    #[Route('/gestion/restaurant', name: 'app_restaurant')]
    public function index(): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'controller_name' => 'RestaurantController',
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
