<?php
// src/Controller/UserController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UserController extends AbstractController
{
    #[Route('/api/user/create', methods: ['POST'])]
    public function createUser(Request $request, EntityManagerInterface $em, LoggerInterface $logger): JsonResponse
    {   
        $data = json_decode($request->getContent(), true);
        
        // Debugging: Log die empfangenen Daten
        $logger->info('Empfangene Daten: ', $data);
        /*/
        if (!isset($data['token']) || $data['token'] !== $_ENV['TOKEN']) {
            return $this->json([
                'error' => '201 UNAUTHORIZED',
                'client_token' => $data['token'] ?? null
            ]);
        }/*/
        
        if (empty($data['name'])) {
            return $this->json(['error' => 'name is required']);
        }
        
        if (empty($data['password'])) {
            return $this->json(['error' => 'password is required']);
        }
        $user = new User();
        $user->setName($data['name']);
        $user->setPassword($data['password']);
        $em->persist($user);
        $em->flush();
        return($this->json($user));
        
    }
    #[Route('/api/user/Login', methods: ['POST'])]
    public function loginUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {   
        $data = json_decode($request->getContent(), true);

        if (empty($data['name'])) {
            return $this->json(['error' => 'name is required']);
        }
        
        if (empty($data['password'])) {
            return $this->json(['error' => 'password is required']);
        }

        $user = new User();
        $user->setName($data['name']);

        // Passwort hashen
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Speichern in der Datenbank
        $em->persist($user);
        $em->flush();

        // Gebe den User zurück, aber ohne das Passwort (aus Sicherheitsgründen)
        return $this->json([
            'id' => $user->getId(),
            'name' => $user->getName()
        ]);
    }
}

