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
use App\Form\ArticleType;

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
            'article' => $articleFound,
            'edit_url' => $this->generateUrl('update_article', ['id' => $articleFound->getId()])
        ]);

    }

//Cette route affichera le resultat de la recherche d'article
    #[Route('/articles/search-results', 'article_search_results')]
    public function articleSearchResults(Request $request,ArticleRepository $articleRepository): Response
    {

        //Récupere le resultat de la recherche
        $search = $request->query->get('search');

        $articles = $articleRepository->search($search);

//Renvoi le resultat de la recherche
        return $this->render('article_search_results.html.twig', [
            'search' => $search,
            'article' => $articles,
            'category' => null
        ]);

    }



//Cette route sert à créer un nouvel article
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
    //On crée une route qui permet de supprimer un article
    #[Route('/article/delete/{id}', 'delete_article',  ['id' => '\d+'])]
    public function removeArticle(int $id, EntityManagerInterface $entityManager, ArticleRepository $articleRepository): Response {
//On recherche l'article par son ID
        $article = $articleRepository->find($id);
//Si l'article n'existe pas en renvoi ver sune page indiquant "not found"
        if (!$article) {
            return $this->redirectToRoute('not_found');
        }
//On supprime l'article de la base de donnée
        $entityManager->remove($article);
        $entityManager->flush();
//On renvoie la confirmation de suppression
        return $this->render('article_delete.html.twig', [
            'article' => $article
        ]);
    }
//On crée la route qui met a jour un article
    #[Route('/article/update/{id}', 'update_article',  ['id' => '\d+'])]
    public function updateArticle(int $id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager, Request $request)
    {
        // je récupère en BDD l'article lié à l'id de l'url
        // Doctrine (ORM) me créé une instance de l'entité Article
        // et la remplie avec les données de l'article en BDD
        $article = $articleRepository->find($id);

        $message = "Veuillez remplir les champs";


        //On crée une boucle qui dit que si c'est une requête POST
        if ($request->isMethod('POST')) {

            // On récupère la valeur des champs et si ils n'ont pas été modifiés, on récupére la valeur de base qui était dans la BDD
            $title = $request->request->get('title');
            $content = $request->request->get('content');
            $image = $request->request->get('image');

            // On modifie les valeurs de l'entité avec celles des champs
            $article->setTitle($title);
            $article->setContent($content);
            $article->setImage($image);

            // On mets à jour l'article en BDD
            $entityManager->persist($article);
            $entityManager->flush();

            $message = "L'article '" . $article->getTitle() . "' a bien été mis à jour";
        }

        // On envoie au formulaire twig l'article qui existe en BDD et qui va pré-remplir les champs
        return $this->render('article_update.html.twig', [
            'article' => $article,
            'message' => $message
        ]);
    }

}