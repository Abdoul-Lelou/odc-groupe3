<?php


namespace App\Controller\Api;
use App\Repository\ParkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;



class ParkApi extends AbstractController
{
    private $parkRepo;
    private $serialize;
    public function __construct(ParkRepository $parkRepository, SerializerInterface $serializerInterface){
        $this->parkRepo = $parkRepository;
        $this->serialize = $serializerInterface;
    }
    /**
     * @Route("/api/list-parks", name="list_park")
     *
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $listParks = $this->parkRepo->findAll();

        $listParksJson = $this->serialize->serialize($listParks, 'json', ['groups' => 'park:read']);

        return new JsonResponse($listParksJson, 200, [], 'json');
        // $usersJson = $this->serializer->serialize($users, 'json', ['groups' => 'user:read', 'membre:read']);

    }
}