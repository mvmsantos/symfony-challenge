<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CourseCategoryRepository;
use App\Entity\CourseCategory;

class CourseCategoryController extends AbstractController
{
  #[Route('/coursescategory', name: 'coursescategory_list', methods: ['GET'])]
  public function index(CourseCategoryRepository $courseCategoryRepository): JsonResponse
  {
    return $this->json([
      'data' => $courseCategoryRepository->findAll(),
    ]);
  }

  #[Route('/coursescategory/{coursecategory}', name: 'coursescategory_single', methods: ['GET'])]
  public function single(int $course, CourseCategoryRepository $CourseCategoryRepository): JsonResponse
      {
        $course = $CourseRepository->find($course);

        if(!$course) {
          throw $this->createNotFoundException('Course category not found!');
        }

        return $this->json([
          'data' => $course,
        ]);
      }

      #[Route('/coursescategory/{coursecategory}', name: 'coursescategory_create', methods: ['POST'])]
      public function create(Request $request, CourseCategoryRepository $CourseCategoryRepository): JsonResponse
      {
        $data = $request->toArray();

        $course = new course();
        $course->setCategory($data['category']);
        $course->setStatus('Ativo');
        $course->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $course->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $CourseCategoryRepository->save($course, true);

        return $this->json([
            'message' => 'Course category created successfully',
            'data' => $course,
        ], 201);
      }

      #[Route('/courses/{course}', name: 'courses_update', methods: ['PUT', 'PATCH'])]
      public function update(int $course, Request $request, CourseRepository $CourseRepository): JsonResponse
      {
        $course = $CourseRepository->find($course);

        if(!$course) {
          throw $this->createNotFoundException('course not found!');
        }

        $data = $request->toArray();

        $course->setCategory($data['name']);
        $course->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $CourseCategoryRepository->save($course, true);

        return $this->json([
            'message' => 'course updated successfully',
            'data' => $course,
        ], 200);
      }

      #[Route('/courses/{course}', name: 'courses_delete', methods: ['DELETE'])]
      public function delete(int $course, Request $request, courseCategoryRepository $courseCategoryRepository): JsonResponse
      {
        $course = $courseCategoryRepository->find($course);

        if(!$course) {
          throw $this->createNotFoundException('course category not found!');
        }

        $course->setStatus('Inativo');
        $course->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $CourseCategoryRepository->save($course, true);

        return $this->json([
            'message' => 'Course category delete successfully',
        ], 200);
      }
}

