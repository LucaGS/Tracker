<?php

namespace App\Controller;

use App\Entity\Trainingplan;
use App\Repository\TrainingplanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/trainingplan', name: 'api_trainingplan_')]
class TrainingplanController extends AbstractController
{
    #[Route('/', methods: ['GET'])]
    public function index(TrainingplanRepository $repository): JsonResponse
    {
        $plans = $repository->findAll();
        return $this->json($plans);
    }
    #[Route('/user/{userId}', methods: ['GET'])]
    public function GetUserTrainingplans(int $userId,TrainingplanRepository $repository): JsonResponse
    {
        $plans = $repository->findOneBy(["userid"=> $userId]);
        return $this->json($plans);
    }
    


    #[Route('/{id}', methods: ['GET'])]
    public function show(Trainingplan $trainingplan): JsonResponse
    {
        return $this->json($trainingplan);
    }

    #[Route('/', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $plan = new Trainingplan();
        $plan->setName($data['name']);
        $plan->setUserid($data['userid']);

        $em->persist($plan);
        $em->flush();

        return $this->json($plan, 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request, Trainingplan $trainingplan, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $trainingplan->setName($data['name']);
        }
        if (isset($data['userid'])) {
            $trainingplan->setUserid($data['userid']);
        }

        $em->flush();

        return $this->json($trainingplan);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(Trainingplan $trainingplan, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($trainingplan);
        $em->flush();

        return $this->json(['message' => 'Trainingplan deleted'], 204);
    }
}
