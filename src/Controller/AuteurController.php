<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuteurRepository;

final class AuteurController extends AbstractController
{
    #[Route('/auteur', name: 'app_auteur')]
    public function index(AuteurRepository $auteurRepository): Response
    {
        $auteurs = $auteurRepository->findAll();
        
        return $this->render('auteur/index.html.twig', [
            'controller_name' => 'AuteurController',
            'auteurs' => $auteurs,
        ]);
    }

    #[Route('/auteurs/{id}', name: 'app_auteur_detail')]
    public function detail(int $id, AuteurRepository $auteurRepository): Response
    {
        $unAuteur = $auteurRepository->find($id);

        if (!$unAuteur) {
            return $this->createNotFoundException('Cet auteur n\'existe pas');
        }
        return $this->render('auteur/detail.html.twig', [
            'auteurAAfficher' => $unAuteur
        ]);
    }
}
