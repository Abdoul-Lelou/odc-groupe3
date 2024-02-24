<?php

namespace App\Controller;

use App\Entity\Place;
use App\Form\AddPlaceType;
use App\Form\AddStationnementType;
use App\Form\PlaceType;
use App\Repository\ParkRepository;
use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PlaceController extends AbstractController
{
    private $placeRepository;
    public function __construct(PlaceRepository $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }
    /**
     * @Route("/place", name="app_place")
     */
    public function index(): Response
    {

        return $this->render('place/index.html.twig', [
            'places' => $this->placeRepository->findAll(),
        ]);
    }
    /**
     * @Route("/{id}/stationnement", name="app_stationnement_place")
     */
    public function stationnement($id, Request $request) 
    {
        $place = $this->placeRepository->findOneById(intval($id));

        $form = $this->createForm(AddStationnementType::class, $place)->handleRequest($request);

        if ($form->isSubmitted()) {
            $place->setIsDisponible(false);
            
            $this->placeRepository->add($place, true);

            return $this->redirectToRoute('app_place');
        }
        return $this->render('place/add-stationnement.html.twig', [
            'form' => $form->createView()
        ]);

    }
    
    //cette fonction permet de liberer une place
     /**
     * @Route("/{id}/out-stationnement", name="app_out")
     */
    public function outstationnement($id)
    {
        $place=$this->placeRepository->findOneById(intval($id));
        $place->setIsDisponible(true);
        $stationnement=$place->getStationnement();

        $stationnement->setDateOutAt(new \DateTimeImmutable());
        $place->setStationnement($stationnement);

        $this->placeRepository->add($place,true);

        return $this->redirectToRoute("app_place");

    }

   
}
