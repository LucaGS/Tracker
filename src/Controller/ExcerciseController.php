<?php
namespace App\Controller;

use App\Entity\Excercise;
use App\Entity\Test;
use App\Repository\ExcerciseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/api/excercise', name: 'api_excercise_')]
class ExcerciseController extends AbstractController {
    #[Route('/', methods: ['GET'])]
    public function index( ExcerciseRepository $excerciseRepository):JsonResponse{
        $excercises = $excerciseRepository->findAll();
        return $this->json($excercises);
    }
    #[Route('/', methods: ['POST'])]
    public function createExcercise(Request $request,EntityManagerInterface $entityManager,){
       $data = json_decode($request->getContent(),true);

        if(!isset($data['userid'], $data['trainingplanid'],$data['name'],$data['sets'])){
            return $this->json(["error"=> "userid, trainplanid, name, sets are required"]);
        }
        $excercise = new Excercise();
        $excercise->setName($data['name']);
        $excercise->setSets($data['sets']);
        $excercise->setTrainingplanid($data['trainingplanid']);
        $excercise->setUserid($data['userid']);
        $entityManager->persist($excercise);
        $entityManager->flush();
        return $this->json($excercise ,201);

    }
    #[Route('/user/{userid}/{trainingplanid}', methods: ['POST'])]
    public function getUserExcercises(int $userid ,int $trainingplanid, ExcerciseRepository $excerciseRepository){
        $excercises = $excerciseRepository->findBy(
            criteria:
            ["userid" => $userid,
            ["trainingplanid"=>$trainingplanid]],);
        return $this->json($excercises, 201);
    }
}

