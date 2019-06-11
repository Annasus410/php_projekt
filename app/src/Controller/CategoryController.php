<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\User;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{



    /**
     *
     * @param \App\Repository\CategoryRepository      $categoryRepository Repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route("/category/all", name="all_categories")
     */
    public function allCategory(CategoryRepository $categoryRepository): Response

    {


        return $this->render(
            'category/all_categories.html.twig',
            [
            'controller_name' => 'AllCategory',
            'categories' => $categoryRepository->findAll()]
        );
    }



    /**
     * New action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request HTTP request
     * @param \App\Repository\CategoryRepository $repository Category repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "category/add",
     *     methods={"GET", "POST"},
     *     name="category_new",
     * )
     */
    public function new(Request $request, CategoryRepository $repository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $repository->save($category);

            $this->addFlash('success', 'Kategorie dodano prawidłowo');
            return $this->redirectToRoute('all_categories');
        }

        return $this->render(
            'category/add_category.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request    HTTP request
     * @param \App\Entity\Category                         $category      Category entity
     * @param \App\Repository\CategoryRepository            $repository Category repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "category/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="category_edit",
     * )
     */
    public function edit(Request $request, Category $category, CategoryRepository $repository): Response
    {

        $form = $this->createForm(CategoryType::class, $category, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($category);

            $this->addFlash('success', 'Kategoria została edytowana');

            return $this->redirectToRoute('all_categories');
        }

        return $this->render(
            'category/edit.html.twig',
            [
                'form' => $form->createView(),
                'category' => $category,
                'page_title' => 'Edycja ogłoszenia',

            ]
        );
    }


    /**
     * Delete action.
     *
     * @param Request $request
     * @param Category $category
     * @param CategoryRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @Route(
     *     "category/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="category_delete",
     * )
     */
    public function delete(Request $request, Category $category, CategoryRepository $repository): Response
    {
        $form = $this->createForm(CategoryType::class, $category, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->delete($category);
            $this->addFlash('success', 'Kategoria zostało usunięta');

            return $this->redirectToRoute('all_categories');
        }

        return $this->render(
            'category/delete.html.twig',
            [
                'form' => $form->createView(),
                'category' => $category,
                'page_title' => 'Potwierdź skasowanie kategorii',

            ]
        );
    }
    

}