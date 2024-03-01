<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StationnementRepository;
use Symfony\Component\HttpFoundation\Request;



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
    public function index(Request $request): Response
    {

        $station = $this->stationRepository->findAll();
        $page = $request->query->getInt('page', 1);
        $limit = 4; // Users per page

       
        if (count($station) > $limit) {
            $offset = ($page - 1) * $limit;
            $paginatedUsers = array_slice($station, $offset, $limit);
            $totalPages = ceil(count($station) / $limit);
        } else {
            $paginatedUsers = $station;
            $totalPages = 1;
        }

        return $this->render('stationnement/index.html.twig', [
            'stations' => $paginatedUsers,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            // 'form' => $form->createView(),
        ]);
        
    }

    /**
     * @Route("/historique", name="historique")
     */
    public function historique(Request $request): Response
    {
        $today = new \DateTimeImmutable();
        $stationHistory = $this->stationRepository->findByDateLess($today);

        $page = $request->query->getInt('page', 1);
        $limit = 4; // Users per page

       
        if (count($stationHistory) > $limit) {
            $offset = ($page - 1) * $limit;
            $paginatedUsers = array_slice($stationHistory, $offset, $limit);
            $totalPages = ceil(count($stationHistory) / $limit);
        } else {
            $paginatedUsers = $stationHistory;
            $totalPages = 1;
        }

        return $this->render('stationnement/index.html.twig', [
            'stations' => $paginatedUsers,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            // 'form' => $form->createView(),
        ]);

    }

}
