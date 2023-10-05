<?php

// src/Controller/PublicationController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    #[Route('/actualites', name: 'actualites')]
    public function viewPublications(Request $request): Response
    {
        // Récupérez les publications stockées en session (si elles existent)
        $session = $request->getSession();
        $publications = $session->get('publications', []);

        return $this->render('Publication/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    #[Route('/create-publication', name: 'create_publication')]
    public function createPublication(Request $request): Response
    {
        // Récupérez les publications existantes depuis la session
        $session = $request->getSession();
        $publications = $session->get('publications', []);

        if ($request->isMethod('POST')) {
            // Récupérez les données du formulaire
            $title = $request->request->get('title');
            $description = $request->request->get('description');
            $imagePath = $request->request->get('imagePath'); // Vous devrez gérer le téléchargement d'image ici

            // Créez une nouvelle publication
            $newPublication = [
                'title' => $title,
                'description' => $description,
                'imagePath' => $imagePath,
            ];

            // Ajoutez la nouvelle publication à la liste
            $publications[] = $newPublication;

            // Stockez la liste mise à jour en session
            $session->set('publications', $publications);
        }

        // Redirigez vers la page du fil d'actualités
        return $this->render('Publication/index.html.twig');
    }
}
