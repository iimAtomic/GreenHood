<?php

// src/Controller/ImageController.php

// src/Controller/ImageController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ImageController extends AbstractController
{
    #[Route('/image', name: 'app_image')]
    public function uploadImage(Request $request, SessionInterface $session): Response
    {
        // Récupérez le fichier image depuis la requête
        $imageFile = $request->files->get('image');

        // Générez un nom de fichier unique pour éviter les collisions
        $fileName = md5(uniqid()) . '.' . $imageFile->guessExtension();

        // Déplacez le fichier téléchargé vers le répertoire de destination
        $imageFile->move(
            $this->getParameter('kernel.project_dir') . '/public/uploads/images',
            $fileName
        );

        // Vous pouvez enregistrer le nom du fichier dans la base de données si nécessaire

        // Mettez à jour la session pour incrémenter le nombre d'images
        $numberOfImages = $session->get('numberOfImages', 0);
        $numberOfImages++;

        $session->set('numberOfImages', $numberOfImages);

        // Désactivez le bouton dans la session
        $session->set('buttonState', 'disabled');

        // Répondez avec une réponse JSON ou redirigez selon vos besoins
        return $this->render('SousMenu/eco.html.twig');
    }
}
