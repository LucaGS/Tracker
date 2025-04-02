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

    
}
