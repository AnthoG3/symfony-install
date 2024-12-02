<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
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
        $articles = $category->getArticles();

        return $this->render('category_show.html.twig', [
            'category' => $category,
            'articles' => $articles,
        ]);
    }


    #[Route('/category/create', 'create_category', [], ['GET', 'POST'])]
    public function createCategory(EntityManagerInterface $entityManager, Request $request) {

        $category = new Category();

        $formCategory = $this->createForm(CategoryType::class, $category);

        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted()) {
            $entityManager->persist($category);
            $entityManager->flush();
        }

        $formCategoryView = $formCategory->createView();

        return $this->render('category_create.html.twig', [
            'formCategoryView' => $formCategoryView
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

    #[Route('/category/update/{id}', 'update_category', ['id' => '\d+'], ['GET', 'POST'])]
    public function updateCategory(int $id, EntityManagerInterface $entityManager, Request $request, CategoryRepository $categoryRepository) {

        $category = $categoryRepository->find($id);

        $formCategory = $this->createForm(CategoryType::class, $category);

        $formCategory->handleRequest($request);

        if ($formCategory->isSubmitted()) {
            $entityManager->persist($category);
            $entityManager->flush();
        }

        $formCategoryView = $formCategory->createView();

        return $this->render('category_update.html.twig', [
            'formCategoryView' => $formCategoryView
        ]);

    }

}