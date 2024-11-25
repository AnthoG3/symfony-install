<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController //Création de la classe "ArticleController" et AbstractControler
// indique que ArticleController hérite de cette derniere qui permet d'utiliser "render"
{

    #[Route('/articles', 'articles_list')]
    public function articles()  //Définition de la ethode "articles"
    {
        $articles = [ //Création d'un tableau qui contient des sous tableaux, chacuns representant un article avec "id,title,content,image"
            [
                'id' => 1,
                'title' => 'Article 1',
                'content' => 'Youpi un premier article !!!!',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 2,
                'title' => 'Article 2',
                'content' => 'Génial un deuxieme article !!! ',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 3,
                'title' => 'Article 3',
                'content' => 'Oh un troisieme ! Super ! ',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 4,
                'title' => 'Article 4',
                'content' => 'Un quatrieme ? Mais quelle chance ! ',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ],
            [
                'id' => 5,
                'title' => 'Article 5',
                'content' => 'On se fait chier là,non ?',
                'image' => 'https://static.vecteezy.com/system/resources/thumbnails/012/176/986/small_2x/a-3d-rendering-image-of-grassed-hill-nature-scenery-png.png',
            ]

        ];

        return $this->render('articles_list.html.twig', [ //$this-> render est la methode hérité de "AbstractController" pour rendre une vue auquel on ajoute le nom du fichier Twig
            'articles' => $articles
        ]);
    }
}