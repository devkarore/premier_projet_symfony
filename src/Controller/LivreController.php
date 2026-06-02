<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Livre;
use App\Form\LivreType;

final class LivreController extends AbstractController
{
    #[Route('/livres', name: 'app_livres')]
    public function index(LivreRepository $repository): Response
    {
        $livres = $repository->findAll();

        return $this->render('livre/index.html.twig', [
            'controller_name' => 'LivreController',
            'livres' => $livres
        ]);
    }

    #[Route('/livre/nouveau', name: 'app_livre_nouveau')]
    public function nouveau(Request $request, EntityManagerInterface $em): Response
    {
        // On crée un objet vide
        $livre = new Livre();
        // On crée notre formulaire basé sur la classe de formulaire que l'on a créé et on lui passe l'objet vide à hydrater
        $form = $this->createForm(LivreType::class, $livre);

        // On récupère les informations de la requête : Si c'est un POST alors $livre prend les valeurs du formulaire
        $form->handleRequest($request);
        // Si on a envoyé le formulaire alors on persiste $livre et on renvoie vers la liste
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($livre);
            $em->flush();

            return $this->redirectToRoute('app_livres');
        }
        // Sinon on affiche le template en passant le formulaire en paramètre 
        return $this->render('livre/nouveau.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/livre/{id}', name: 'app_livre_detail')]
    public function detail(int $id, LivreRepository $repository)
    {
        $monLivre = $repository->find($id);

        if (!$monLivre) {
            return $this->createNotFoundException('Ce livre n\'existe pas');
        }
        return $this->render('livre/detail.html.twig', [
            'livreAAfficher' => $monLivre
        ]);
    }
}