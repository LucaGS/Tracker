<?php
// src/Controller/UserController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/api/User', methods: ['POST'])]
    public function createUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): JsonResponse
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

