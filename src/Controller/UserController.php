<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/users')]
class UserController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function getUsers(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        $data = array_map(fn(User $user) => [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'mail' => $user->getMail(),
        ], $users);

        return $this->json($data);
    }

    #[Route('/{id}', methods: ['GET'])]
    public function getUserById(int $id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);
    
        if (!$user) {
            return $this->json(['message' => 'User not found'], 404);
        }
    
        return $this->json([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'mail' => $user->getMail(),
        ]);
    }

    #[Route('', methods: ['POST'])]
    public function createUser(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'], $data['mail'], $data['password'])) {
            return $this->json(['message' => 'Invalid data'], 400);
        }

        $user = new User();
        $user->setName($data['name']);
        $user->setMail($data['mail']);
        $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json(['message' => 'User created successfully',
    "id"=>$user->getId()], 201);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function updateUser(int $id, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->json(['message' => 'User not found'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['name'])) {
            $user->setName($data['name']);
        }
        if (isset($data['mail'])) {
            $user->setMail($data['mail']);
        }
        if (isset($data['password'])) {
            $user->setPassword(password_hash($data['password'], PASSWORD_DEFAULT));
        }

        $entityManager->flush();

        return $this->json(['message' => 'User updated successfully']);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function deleteUser(int $id, UserRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            return $this->json(['message' => 'User not found'], 404);
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->json(['message' => 'User deleted successfully']);
    }
}
