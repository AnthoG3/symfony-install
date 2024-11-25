<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', 'home')]

    public function home()
    {
        return $this->render('base.html.twig', [
            'title' => 'Bienvenue sur la page !',
        ]);
    }
}