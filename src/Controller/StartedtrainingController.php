<?php
namespace App\Controller;

use App\Entity\Startedtraining;
use App\Entity\Trainingplan;
use App\Repository\StartedtrainingRepository;
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
    #[Route(path:"", methods:["GET"])]
    public function index( StartedtrainingRepository $repositry):JsonResponse{
        $trainings = $repositry->findAll();
        return $this->json($trainings);
        
    }
    #[Route(path:'', methods:["POST"])]
    public function create(Request $request, EntityManagerInterface $em){
        $data = json_decode($request->getContent());
        if(!empty($data['userid'])){
            $this->json(["error"=>"userid is required"]);

        }
        if(!empty($data['trainingplanid'])){
            $this->json(["error"=>"trainingplanid is required"]);
            
        }
    }
}
