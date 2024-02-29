<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StationnementRepository;


class StationnementController extends AbstractController
{
    

     private $stationRepository;
    public function __construct(StationnementRepository $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }

    /**
     * @Route("/stationnement", name="app_stationnement")
     */
    public function index(): Response
    {
        return $this->render('stationnement/index.html.twig', [
            'stations' => $this->stationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/historique", name="historique")
     */
    public function historique(): Response
    {
        $today = new \DateTimeImmutable();
        // dd($this->stationRepository->findByDateLess($today));
        $stationHistory = $this->stationRepository->findByDateLess($today);
        return $this->render('stationnement/index.html.twig', [
            'stations' => $stationHistory,
        ]);
    }

}
