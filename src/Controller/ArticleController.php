<?php

namespace App\Controller;

//Importation des classes nécessaires
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//Création de la classe controller "ArticleController" qui utilise "AbstractController"
class ArticleController extends AbstractController
{
    //Route qui sert à afficher la liste des articles
    #[Route('/articles', 'articles_list')]
    public function articles(ArticleRepository $articleRepository): Response
    {

        //Ici on récupére tous les articles
        $articles = $articleRepository->findAll();

        //Renvoi la liste des articles
        return $this->render('articles_list.html.twig', [
            'articles' => $articles
        ]);

    }

    //On crée une route qui affichera un article en particulier
    #[Route('/article/{id}', 'article_show', ['id' => '\d+'])]
    public function showArticle(int $id, ArticleRepository $articleRepository): Response
    {
        //On cherche l'article par son ID
        $articleFound = $articleRepository->find($id);

        //Redirige vers une page "not found" si l'article demandé n'existe pas
        if (!$articleFound) {
            return $this->redirectToRoute('not_found');
        }
    //Renvoi l'article qui a ete trouvé
        return $this->render('article_show.html.twig', [
            'article' => $articleFound
        ]);

    }

//Cette route affichera le resultat de la recherche d'article
    #[Route('/articles/search-results', 'article_search_results')]
    public function articleSearchResults(Request $request): Response {

        //Récupere le resultat de la recherche
        $search = $request->query->get('search');

//Renvoi le resultat de la recherche
        return $this->render('article_search_results.html.twig', [
            'search' => $search
        ]);

    }

//Cette route sert à créer un nouvel article
    #[Route('/article/create', 'create_article')]
    public function createArticle(EntityManagerInterface $entityManager): Response {

//On crée une nouvelle instance de la class article
        $article = new Article();

        //On définit les propriétées de l'article
        $article->setTitle('Article 5');
        $article->setContent('Contenu article 5');
        $article->setImage("https://cdn.futura-sciences.com/sources/images/AI-creation.jpg");
        $article->setCreatedAt(new \DateTime());

//Persist "prépare" l'entité à se lier à la base (LA JE SUIS PAS CERTAIN DE MON TRUC)
        $entityManager->persist($article);

//On exécute les requetes SQL pour sauvegarder l'entité
        $entityManager->flush();


        return new Response('OK'); //Retourne une reponse
    }

}