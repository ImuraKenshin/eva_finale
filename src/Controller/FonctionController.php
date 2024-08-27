<?php

namespace App\Controller;

use App\Entity\Fonction;
use App\form\FonctionType;
use App\Repository\FonctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FonctionController extends AbstractController
{
    #[Route('/fonction/gestion', name: 'app_fonction')]
    public function index(FonctionRepository $FonctionRepository): Response
    {
        $fonctions = $FonctionRepository->ListeAll();

        return $this->render('fonction/listeFonction.html.twig', [
            'fonctions' => $fonctions,
        ]);
    }

    #[Route('/fonction/edition/{id}', name: 'fonction_edition')]
    public function editionFonction(Fonction $fonction, Request $request, EntityManagerInterface $em): Response
    {

        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            
            return $this->redirectToRoute("app_fonction");
        }

        return $this->render('formulaire/editFonction.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/fonction/creation', name: 'fonction_creation')]
    public function creationFonction(Request $request, EntityManagerInterface $em): Response
    {
        $fonction = new Fonction();

        $form = $this->createForm(FonctionType::class, $fonction);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($fonction);
            $em->flush();
            
            return $this->redirectToRoute("app_fonction");
        }

        return $this->render('formulaire/addFonction.html.twig', [
            'form' => $form,
        ]);
    }
}
