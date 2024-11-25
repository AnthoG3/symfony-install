<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PokerController
{
    #[Route('/poker', 'poker')]
    public function poker()

    {

        //appelle la methode createFromGlobals sans avoir besoin de faire l'instance de classe manuellement
        // Cette methode permet de remplir la variable $request avec toutes les données de requete (GET,POST,SESSION...)
        $request = Request::createFromGlobals();

        //J'utilise la propriété query qui me permet de récuperer les données GET
        $age = $request->query->get('age');

        var_dump($age); die;

        return new Response('Bienvenue sur ce super site de poker en ligne');
    }
}