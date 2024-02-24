<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StationnementController extends AbstractController
{
    /**
     * @Route("/stationnement", name="app_stationnement")
     */
    public function index(): Response
    {
        return $this->render('stationnement/index.html.twig', [
            'controller_name' => 'StationnementController',
        ]);
    }
}
