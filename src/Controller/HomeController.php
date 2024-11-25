<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\component\HttpFoundation\Response;

class HomeController //Création de la classe HomeController

{

#[Route('/', 'home')] //Création de la route pour la methode "home" le signe # est comme un commentaire lu et utilisé par PHP

    public function home() // Création de la fonction "home" qui retourne une instance de classe "Response" qui vient de Symfony
//La classe permet de créer une reponse HTTP valide et prend en compte l'HTML de return a envoyer au navigateur.
    {
        return new Response(content: '<h1>Page d\'accueil</h1>');
    }
}
