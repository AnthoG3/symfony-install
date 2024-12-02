<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', 'home')]
    public function home() {
        return $this->render('home.html.twig');
    }

    #[Route('/search-results', 'search_results')]
    public function searchResults(Request $request, ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response {
        $search = $request->query->get('search');

        $articles = $articleRepository->search($search);
        $categories = $categoryRepository->search($search);

        return $this->render('search_results.html.twig', [
            'search' => $search,
            'articles' => $articles,
            'categories' => $categories,
        ]);

    }

}