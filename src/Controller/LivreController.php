<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\LivreRepository;

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

    #[Route('/livres/{id}', name: 'app_livre_detail')]
    public function detail(int $id, LivreRepository $repository): Response
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