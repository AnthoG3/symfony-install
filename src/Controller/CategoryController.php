<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    #[Route('/categories', 'list_categories')]
    public function listCategories(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('categories_list.html.twig', [
            'categories' => $categories
        ]);
    }


    #[Route('/category/{id}', 'show_category', requirements: ['id' => '\d+'])]
    public function showCategory(int $id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);

        return $this->render('category_show.html.twig', [
            'category' => $category
        ]);
    }


    #[Route('/category/create', 'create_category')]
    public function createCategory(EntityManagerInterface $entityManager) {
        $category = new Category();
        $category->setTitle('International');

        $category->setColor('red');

        $entityManager->persist($category);
        $entityManager->flush();

        return $this->render('category_create.html.twig', [
            'category' => $category
        ]);

    }
    //Cette route affichera le resultat de la recherche d'article
    #[Route('/article/search-results', 'article_search_results')]
    public function articleSearchResults(Request $request,ArticleRepository $articleRepository): Response
    {

        //Récupere le resultat de la recherche
        $search = $request->query->get('search');

        $category = $articleRepository->search($search);

//Renvoi le resultat de la recherche
        return $this->render('article_search_results.html.twig', [
            'search' => $search,
            'category' => $category,
            'article' => null
        ]);

    }


    #[Route('/category/delete/{id}', 'delete_category', ['id' => '\d+'])]
    public function removeCategory(int $id, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager): Response
    {
        $category = $categoryRepository->find($id);

        $entityManager->remove($category);
        $entityManager->flush();

        return $this->render('category_delete.html.twig', [
            'category' => $category
        ]);


    }

}