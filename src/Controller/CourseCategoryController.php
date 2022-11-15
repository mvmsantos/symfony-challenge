<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CourseCategoryRepository;
use App\Entity\CourseCategory;
use Symfony\Component\HttpFoundation\Request;

class CourseCategoryController extends AbstractController
{
  #[Route('/coursescategory', name: 'coursesCategory_list', methods: ['GET'])]
  public function index(CourseCategoryRepository $courseCategoryRepository): JsonResponse
  {
    return $this->json([
      'data' => $courseCategoryRepository->findAll(),
    ]);
  }

  #[Route('/coursescategory/{courseCategory}', name: 'coursesCategory_single', methods: ['GET'])]
  public function single(int $courseCategory, CourseCategoryRepository $courseCategoryRepository): JsonResponse
  {
    $courseCategory = $courseCategoryRepository->find($courseCategory);

    if(!$courseCategory) {
      throw $this->createNotFoundException('Course category not found!');
    }

    return $this->json([
      'data' => $courseCategory,
    ]);
  }

  #[Route('/coursescategory', name: 'coursescategory_create', methods: ['POST'])]
  public function create(Request $request, CourseCategoryRepository $courseCategoryRepository): JsonResponse
  {
    $data = $request->toArray();

    $courseCategory = new CourseCategory();
    $courseCategory->setCategory($data['category']);
    $courseCategory->setStatus('Ativo');
    $courseCategory->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
    $courseCategory->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

    $courseCategoryRepository->save($courseCategory, true);

    return $this->json([
      'message' => 'Course category created successfully',
      'data' => $courseCategory,
    ], 201);
  }

  #[Route('/coursescategory/{courseCategory}', name: 'coursescategory_update', methods: ['PUT', 'PATCH'])]
  public function update(int $courseCategory, Request $request, CourseCategoryRepository $courseCategoryRepository): JsonResponse
  {
    $courseCategory = $courseCategoryRepository->find($courseCategory);

    if(!$courseCategory) {
      throw $this->createNotFoundException('Course category not found!');
    }

    $data = $request->toArray();

    $courseCategory->setCategory($data['category']);
    $courseCategory->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

    $courseCategoryRepository->save($courseCategory, true);

    return $this->json([
      'message' => 'course category updated successfully',
      'data' => $courseCategory,
    ], 200);
  }

  #[Route('/coursescategory/{courseCategory}', name: 'coursescategory_delete', methods: ['DELETE'])]
  public function delete(int $courseCategory, Request $request, courseCategoryRepository $courseCategoryRepository): JsonResponse
  {
    $courseCategory = $courseCategoryRepository->find($courseCategory);

    if(!$courseCategory) {
      throw $this->createNotFoundException('course category not found!');
    }

    $courseCategory->setStatus('Inativo');
    $courseCategory->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

    $courseCategoryRepository->save($courseCategory, true);

    return $this->json([
        'message' => 'Course category delete successfully',
    ], 200);
  }
}

