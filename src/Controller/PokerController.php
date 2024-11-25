<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PokerController extends AbstractController
{
    #[Route('/poker', 'poker')]
    public function poker()

    {

        //appelle la methode createFromGlobals sans avoir besoin de faire l'instance de classe manuellement
        // Cette methode permet de remplir la variable $request avec toutes les données de requete (GET,POST,SESSION...)
        $request = Request::createFromGlobals();

        //J'utilise la propriété query qui me permet de récuperer les données GET
        $age = $request->query->get('age');


        if ($age >= 18) {
            return $this->render('majeur.html.twig');
        } else {
            return  $this ->render ('mineur.html.twig');
        }
    }
}