<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{


    #[Route('/contact', name: 'contact', methods: ['GET', 'POST'])]
    public function contact(Request $request) {

        $message = "Merci de remplir le formulaire";
        $name = null;

        if ($request->isMethod('POST')) {

            if ($request->request->has('message')) {
                $message = $request->request->get('message');
            } else {
                $message = "le message n'a pas été rempli";
            }

            $name = $request->request->get('name');
        }

        return $this->render('contact.html.twig', [
            'message' => $message,
            'name' => $name
        ]);
    }


}