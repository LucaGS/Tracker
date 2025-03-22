<?php
// src/Controller/TestController.php
namespace App\Controller;

use App\Entity\Test;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TestController extends AbstractController
{
    // Alle Tests abrufen
    #[Route('/api/tests', methods: ['GET'])]
    public function getTests(EntityManagerInterface $em,ParameterBagInterface $params ): JsonResponse
    {   
        $tests = $em->getRepository(Test::class)->findAll();
        return $this->json($tests);
    }

    // Einzelnen Test abrufen
    #[Route('/api/tests/{id}', methods: ['GET'])]
    public function getTest(int $id, EntityManagerInterface $em): JsonResponse
    {
        $test = $em->getRepository(Test::class)->find($id);
        
        if (!$test) {
            return $this->json(['error' => 'Test not found'], 404);
        }

        return $this->json($test);
    }

    // Neuen Test erstellen
    #[Route('/api/tests/create', methods: ['POST'])]
    public function createTest(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data['testname'])) {
            return $this->json(['error' => 'Test name is required'], 400);
        }

        $test = new Test();
        $test->setTestname($data['testname']);

        $em->persist($test);
        $em->flush();
        return $this->json($test, 201);
    }

    // Test löschen
    #[Route('/api/tests/{id}', methods: ['DELETE'])]
    public function deleteTest(int $id, EntityManagerInterface $em): JsonResponse
    {
        $test = $em->getRepository(Test::class)->find($id);

        if (!$test) {
            return $this->json(['error' => 'Test not found'], 404);
        }

        $em->remove($test);
        $em->flush();

        return $this->json(['message' => 'Test deleted']);
    }
}
