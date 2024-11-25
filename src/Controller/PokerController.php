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

        $request = Request::createFromGlobals();

        $age = $request->query->get('age');

        var_dump($age); die;

        return new Response('Bienvenue sur ce super site de poker en ligne');
    }
}