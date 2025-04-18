<?php
namespace App\Controller;
use App\Entity\Startedexcercise;
use App\Entity\Startedtraining;
use App\Entity\Trainingplan;
use App\Repository\StartedexcerciseRepository;
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

#[Route('/api/startedexcercise', name: 'api_startedexcercise_')]
class StartedExcerciseController extends AbstractController{

    #[Route("/", methods:['POST'])]
    public function CreateStartedExcercise(Request $request, EntityManagerInterface $entityManager):JsonResponse{
        $data = json_decode($request->getContent(), true);
        $requiredFields = ['userid','trainingplanid', 'excerciseid', 'startedtrainingplanid', 'set', 'reps', 'weight'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
            return $this->json(['error' => $field . ' is required'], 400);
            }
        }
        $startedExcercise = new Startedexcercise();
        $startedExcercise
            ->setUserid($data['userid'])
            ->setTrainingplanid($data['trainingplanid'])
            ->setExcerciseid($data['excerciseid'])
            ->setStartedtrainingplanid($data['startedtrainingplanid'])
            ->setSet($data['set'])
            ->setReps($data['reps'])
            ->setWeight($data['weight']);


        $entityManager->persist($startedExcercise);
        $entityManager->flush();
        return $this->json($startedExcercise, 201);
    }
    #[Route("/{userid}/{trainingplanid}", methods:['GET'])]
    public function getStartedExcercisesByUserIdAndTrainingplanId(StartedexcerciseRepository $repository, int $userid, int $trainingplanid):JsonResponse{
        $startedExcercises = $repository->findBy(['userid' => $userid, 'trainingplanid' => $trainingplanid]);
        if (!$startedExcercises) {
            return $this->json(['error' => 'Started excercise not found userid:'. $userid ." Trainingplan id:". $trainingplanid], 404);
        }
        
        return $this->json($startedExcercises, 200);
    }
    #[Route("/{userid}/{excerciseid}", methods:['GET'])]
    public function getStartedExcercisesByUserIdAndExcerciseId(StartedexcerciseRepository $repository, int $userid, int $excerciseid):JsonResponse{
        $startedExcercises = $repository->findBy(['userid' => $userid, 'excerciseid' => $excerciseid]);
        if (!$startedExcercises) {
            return $this->json(['error' => 'Started excercise not found userid:'. $userid ." Excercise id:". $excerciseid], 404);
        }
        $excerciseDate = $startedExcercises[0]->getStartedtrainingplanid();
        return $this->json($startedExcercises, 200);
    }
    

}