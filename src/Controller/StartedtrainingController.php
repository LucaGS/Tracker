<?php
namespace App\Controller;
use App\Entity\Startedtraining;
use App\Entity\Trainingplan;
use App\Repository\StartedtrainingRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\isEmpty;
#[Route('/api/startedtraining', name: 'api_trainingplan_')]
class StartedtrainingController extends AbstractController{
    #[Route("/", methods:['POST'])]
    public function CreateStartedTrainingplan(Request $request, EntityManagerInterface $entityManager):JsonResponse{
        $data = json_decode($request->getContent(), true);
        if (empty($data['userid'])) {
            return $this->json(['error' => 'User ID is required'], 400);
        }

        if (empty($data['trainingplanid'])) {
            return $this->json(['error' => 'Training Plan ID is required'], 400);
        }
        $startedTraining = new Startedtraining();
        $startedTraining->setUserid($data['userid']);
        $startedTraining->setTrainingplanid($data['trainingplanid']);
        $entityManager->persist($startedTraining);
        $entityManager->flush();
        return $this->json($startedTraining, 201);
    }
    #[Route("/{userid}/{trainingplanid}", methods:['GET'])]
    public function getStartedTrainingPlansByUserIdAndTrainingplanId(StartedtrainingRepository $repository, int $userid, int $trainingplanid):JsonResponse{
        $startedTraining = $repository->findBy(['userid' => $userid, 'trainingplanid' => $trainingplanid]);
        if (!$startedTraining) {
            return $this->json(['error' => 'Started training not found'], 404);
        }
        return $this->json($startedTraining);
    }
    
}
