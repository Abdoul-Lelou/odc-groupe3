<?php

namespace App\Controller;

use App\Entity\Structure;
use App\Form\StructureType;
use App\Repository\StructureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StructureController extends AbstractController
{
    /**
     * @Route("/structure", name="app_structure")
     */
    public function index(Request $request, StructureRepository $structureRepository): Response
    {
      
        $strucutreExist = $structureRepository->findOneBy([]);

        // $form = $strucutreExist != null ? $this->createForm(StructureType::class, $strucutreExist): $this->createForm(StructureType::class, $structure);

        $form = null;

        $structureValide = null;
        if($strucutreExist != null){
            $form = $this->createForm(StructureType::class, $strucutreExist);
            $structureValide = $strucutreExist;
        }else {
            $structure = new Structure;
            $form = $this->createForm(StructureType::class, $structure);
            $structureValide = $structure;
        }
        
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $structureRepository->add($structureValide, true);
        }


        return $this->render('structure/index.html.twig', [
            'controller_name' => 'StructureController',
            'form'=> $form->createView(),
            'structure'=> $structureValide
        ]);
    }
}
