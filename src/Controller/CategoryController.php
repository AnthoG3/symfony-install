<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

}