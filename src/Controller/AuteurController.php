<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AuteurRepository;
use App\Entity\Auteur;
use App\Form\AuteurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class AuteurController extends AbstractController
{
    #[Route('/auteurs', name: 'app_auteur')]
    public function index(AuteurRepository $auteurRepository): Response
    {
        $auteurs = $auteurRepository->findAll();
        
        return $this->render('auteur/index.html.twig', [
            'controller_name' => 'AuteurController',
            'auteurs' => $auteurs,
        ]);
    }

    #[Route('/auteur/nouveau', name: 'app_auteur_nouveau')]
    public function nouveau(Request $request, EntityManagerInterface $em): Response
    {
        // On crée un objet vide
        $auteur = new Auteur();
        // On crée notre formulaire basé sur la classe de formulaire que l'on a créé et on lui passe l'objet vide à hydrater
        $form = $this->createForm(AuteurType::class, $auteur);

        // On récupère les informations de la requête : Si c'est un POST alors $auteur prend les valeurs du formulaire
        $form->handleRequest($request);
        // Si on a envoyé le formulaire alors on persiste $auteur et on renvoie vers la liste
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($auteur);
            $em->flush();

            return $this->redirectToRoute('app_auteurs');
        }
        // Sinon on affiche le template en passant le formulaire en paramètre 
        return $this->render('auteur/nouveau.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/auteur/{id}', name: 'app_auteur_detail')]
    public function detail(int $id, AuteurRepository $auteurRepository)
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
