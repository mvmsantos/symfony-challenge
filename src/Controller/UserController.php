<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Entity\User;

class UserController extends AbstractController
{
    #[Route('/users', name: 'users_list', methods: ['GET'])]
    public function index(UserRepository $userRepository): JsonResponse
    {
      return $this->json([
        'data' => $userRepository->findAll(),
      ]);
    }

    #[Route('/users/{user}', name: 'users_single', methods: ['GET'])]
    public function single(int $user, UserRepository $userRepository): JsonResponse
    {
      $user = $userRepository->find($user);

      if(!$user) {
        throw $this->createNotFoundException('User not found!');
      }

      return $this->json([
        'data' => $user,
      ]);
    }

    #[Route('/users', name: 'users_create', methods: ['POST'])]
    public function create(Request $request, UserRepository $userRepository): JsonResponse
    {
      $data = $request->toArray();

      $user = new User();
      $user->setName($data['name']);
      $user->setEmail($data['email']);
      $user->setPassword($data['password']);
      $user->setStatus('Ativo');
      $user->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
      $user->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

      $userRepository->save($user, true);

      return $this->json([
          'message' => 'User created successfully',
          'data' => $user,
      ], 201);
    }

    #[Route('/users/{user}', name: 'users_update', methods: ['PUT', 'PATCH'])]
    public function update(int $user, Request $request, UserRepository $userRepository): JsonResponse
    {
      $user = $userRepository->find($user);

      if(!$user) {
        throw $this->createNotFoundException('User not found!');
      }

      $data = $request->toArray();

      $user->setName($data['name']);
      $user->setEmail($data['email']);
      $user->setPassword($data['password']);
      $user->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

      $userRepository->save($user, true);

      return $this->json([
          'message' => 'User updated successfully',
          'data' => $user,
      ], 200);
    }

    #[Route('/users/{user}', name: 'users_delete', methods: ['DELETE'])]
    public function delete(int $user, Request $request, UserRepository $userRepository): JsonResponse
    {
      $user = $userRepository->find($user);

      if(!$user) {
        throw $this->createNotFoundException('User not found!');
      }

      $user->setStatus('Inativo');
      $user->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

      $userRepository->save($user, true);

      return $this->json([
          'message' => 'User delete successfully',
      ], 200);
    }
}
