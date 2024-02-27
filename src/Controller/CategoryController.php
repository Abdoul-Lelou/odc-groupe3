<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    private $categoryRepo;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }
    
    /**
     * @Route("/", name="app_category_index")
     */
    public function list(): Response
    {
        $categories = $this->categoryRepo->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

     /**
     * @Route("/new", name="app_category_new")
     */
    public function add(Request $request): Response
    {
        $categorie = new Category;
        $form = $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted())  {
            $this->categoryRepo->add($categorie, true);

            return $this->redirectToRoute('app_category_index');
        }

        return $this->renderForm('category/_form.html.twig', [
            'form' => $form
        ]);
    }


     /**
     * @Route("/{id}/details", name="app_category_show")
     */
    public function show($id): Response
    {
        $category = $this->categoryRepo->findOneById(intval($id));

        return $this->render('category/show.html.twig', [
            'categorie' => $category,
        ]);
    }

     /**
     * @Route("/category/{id}", name="edit_category")
     */
    public function edit(Request $request, $id): Response
    {
        $category = $this->categoryRepo->findOneById(intval($id));

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted())  {
            $this->categoryRepo->add($category, true);

            return $this->redirectToRoute('app_category_index');
        }

        return $this->render('category/edit.html.twig', [
            'form' => $form->createView() ,
            
        ]);
    }
     
}
