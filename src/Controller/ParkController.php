<?php

namespace App\Controller;

use App\Entity\Park;
use App\Entity\Place;
use App\Form\AddManagerType;
use App\Form\AddPlaceType;
use App\Form\Park1Type;
use App\Form\ParkType;
use App\Form\PlaceType;
use App\Repository\ParkRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/park")
 */
class ParkController extends AbstractController
{
    const ROLES_GESTIONNAIRE = 'ROLE_GEST';

    private  $parkRepository;
    public function __construct(ParkRepository $parkRepository)
    {
        $this->parkRepository = $parkRepository;
    }

    /**
     * @Route("/", name="app_park_index", methods={"GET"})
     */
    public function index(ParkRepository $parkRepository): Response
    {
        return $this->render('park/index.html.twig', [
            'parks' => $parkRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_park_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ParkRepository $parkRepository): Response
    {
        $park = new Park();
        $form = $this->createForm(ParkType::class, $park);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parkRepository->add($park, true);

            return $this->redirectToRoute('app_park_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('park/new.html.twig', [
            'park' => $park,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_park_show", methods={"GET"})
     */
    public function show(Park $park): Response
    {
        return $this->render('park/detail-park.html.twig', [
            'park' => $park,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_park_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Park $park, ParkRepository $parkRepository): Response
    {
        $form = $this->createForm(ParkType::class, $park);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parkRepository->add($park, true);

            return $this->redirectToRoute('app_park_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('park/edit.html.twig', [
            'park' => $park,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_park_delete", methods={"POST"})
     */
    public function delete(Request $request, Park $park, ParkRepository $parkRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$park->getId(), $request->request->get('_token'))) {
            $parkRepository->remove($park, true);
        }

        return $this->redirectToRoute('app_park_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/ajout-place/{id}", name="app_place_to_park", methods={"GET", "POST"})
     */
    public function addPlace($id, Request $request, ParkRepository $parkRepository): Response
    {

        $park = $parkRepository->findOneById(intval($id));
        $place = new Place();
        
        
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted()){
            $park->addPlace($place);
            $parkRepository->add($park, true);

            return $this->redirectToRoute('app_park_index');
        }

        return $this->renderForm('park/add-place.html.twig', [
            'park' => $park,
            'form' => $form,
        ]);
    

    }


    /**
     * @Route("/ajout-gestionnaire/{id}", name="app_add_gestionaire", methods={"GET", "POST"})
     */
    public function addGestionnaire($id, Request $request, UserRepository $userRepository)
    {
        $user_gestionnaire = $userRepository->findBy(['profile' => self::ROLES_GESTIONNAIRE]);
        
        $park = $this->parkRepository->findOneById(intval($id));

        $form = $this->createForm(AddManagerType::class, $park)->handleRequest($request);

        if($form->isSubmitted()) {
            $manager = $form->getData()->getUser();
            $park->setUser($manager);

            $this->parkRepository->add($park, true);

            return $this->redirectToRoute('app_park_index');
        }

        return $this->renderForm('park/add-gestionnaire.html.twig', [
            'form'=> $form
        ]);


        // dd($user_gestionnaire);
    }




    
}
