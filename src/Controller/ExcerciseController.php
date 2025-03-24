<?php
namespace App\Controller;

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
    public function index(EntityManagerInterface $entityManagerInterface, ExcerciseRepository $repository):JsonResponse{
        $excercises = $repository->findAll();
        return $this->json($excercises);
    }
}