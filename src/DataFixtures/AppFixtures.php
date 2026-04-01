<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $auteurs = [ 
            [ 
                'nom' => 'Tolkien', 
                'prenom' => 'J.R.R.', 
                'nationalite' => 'Britannique', 
                'dateNaissance' => new \DateTimeImmutable('1892-01-03'), 
                'biographie' => 'Romancier et philologue britannique, auteur du Seigneur des Anneaux.', 
                ], 
            [ 
                'nom' => 'Herbert', 
                'prenom' => 'Frank', 
                'nationalite' => 'Américaine', 
                'dateNaissance' => new \DateTimeImmutable('1920-10-08'), 
                'biographie' => 'Auteur de science-fiction américain, connu pour le cycle Dune.', 
                ], 
                [ 
                'nom' => 'Orwell', 
                'prenom' => 'George', 
                'nationalite' => 'Britannique', 
                'dateNaissance' => new \DateTimeImmutable('1903-06-25'), 
                'biographie' => 'Romancier et essayiste britannique, auteur de 1984 et La Ferme des animaux.', 
                ] 
            ];
            
        foreach ($auteurs as $data) {
            $auteur = new Auteur();
            $auteur->setNom($data['nom']);
            $auteur->setPrenom($data['prenom']);
            $auteur->setNationalite($data['nationalite']);
            $auteur->setDateNaissance($data['dateNaissance']);
            $auteur->setBiographie($data['biographie']);
            
            $manager->persist($auteur);
            // On stocke une reférence pour pouvoir la réutiliser plus bas
            $this->addReference('auteur-' . $data['prenom'] . ' ' . $data['nom'], $auteur);


            // exemple auteur-nom
            }
            
        $livres = [
            [
                'titre' => 'Le Seigneur des Anneaux',
                'auteur' => 'J.R.R. Tolkien',
                'annee' => 1954,
                'genre' => 'Fantasy',
                'resume' => 'Un hobbit part à l\'aventure pour détruire un anneau maléfique.'
            ],
            [            
                'titre' => 'Dune',
                'auteur' => 'Frank Herbert',
                'annee' => 1965,
                'genre' => 'Science-fiction',
                'resume' => 'Sur une planète désertique, un jeune noble affronte son destin.'
            ],
            [            
                'titre' => '1984',
                'auteur' => 'Georges Orwell',
                'annee' => 1949,
                'genre' => 'Dystopie',
                'resume' => 'Dans un monde totalitaire, un homme tente de résister au système.'
            ]
        ];

        foreach ($livres as $data) {
            // On crée un nouvel objet Livre à chaque tour de boucle
            $livre = new Livre();
            $livre->setTitre($data['titre']);
            $livre->setAnnee($data['annee']);
            $livre->setGenre($data['genre']);
            $livre->setResume($data['resume']);

            $livre->setAuteur($this->getReference('auteur-' . $data['auteur'], Auteur::class));
            // Et on dit à l'ObjectManager de PERSISTER le livre que l'on vient de créer
            $manager->persist($livre);
        }

            $manager->flush();
    }
}
