<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/articles', 'articles_list')]
    public function articles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();

        return $this->render('articles_list.html.twig', [
            'articles' => $articles
        ]);

    }

    #[Route('/article/{id}', 'article_show', ['id' => '\d+'])]
    public function showArticle(int $id, ArticleRepository $articleRepository): Response
    {
        $articleFound = $articleRepository->find($id);

        if (!$articleFound) {
            return $this->redirectToRoute('not_found');
        }

        return $this->render('article_show.html.twig', [
            'article' => $articleFound
        ]);

    }

    #[Route('/article/create', 'create_article')]
    public function createArticle(EntityManagerInterface $entityManager, Request $request): Response {

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        // je demande au formulaire de symfony
        // de récupérer les données de la requête
        // et de remplir automatiquement l'entité $article avec
        // donc de récupérer les données de chaque input
        // et de les stocker dans les propriétés de l'entité (setTitle() etc)
        $form->handleRequest($request);

        // je vérifie que les données ont été envoyées
        if ($form->isSubmitted()) {
            // je mets automatiquement la date de création de mon article
            // car je ne veux pas que ce soit choisi par l'utilisateur
            $article->setCreatedAt(new \DateTime());

            // j'enregistre l'entité article dans ma bdd
            $entityManager->persist($article);
            $entityManager->flush();
        }

        $formView = $form->createView();

        return $this->render('article_create.html.twig', [
            'formView' => $formView
        ]);
    }


    #[Route('/article/delete/{id}', 'delete_article',  ['id' => '\d+'])]
    public function removeArticle(int $id, EntityManagerInterface $entityManager, ArticleRepository $articleRepository): Response {

        $article = $articleRepository->find($id);

        if (!$article) {
            return $this->redirectToRoute('not_found');
        }

        $entityManager->remove($article);
        $entityManager->flush();

        return $this->render('article_delete.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/article/update/{id}', 'update_article',  ['id' => '\d+'])]
    public function updateArticle(int $id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request)
    {
        $article = $articleRepository->find($id);

        $message = "Veuillez remplir les champs";

        if ($request->isMethod('POST')) {

            $title = $request->request->get('title');
            $content = $request->request->get('content');
            $image = $request->request->get('image');

            $article->setTitle($title);
            $article->setContent($content);
            $article->setImage($image);

            $entityManager->persist($article);
            $entityManager->flush();

            $message = "L'article '" . $article->getTitle() . "' a bien été mis à jour";
        }

        return $this->render('article_update.html.twig', [
            'article' => $article,
            'message' => $message
        ]);
    }

}