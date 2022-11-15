<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CourseRepository;
use App\Entity\Course;

class CourseController extends AbstractController
{

  #[Route('/courses', name: 'courses_list',methods: ['GET'])]
  public function index(CourseRepository $CourseRepository): JsonResponse
  {
    return $this->json([
      'data' => $CourseRepository->findAll(),
    ]);
  }

      #[Route('/courses/{course}', name: 'courses_single', methods: ['GET'])]
    public function single(int $course, CourseRepository $CourseRepository): JsonResponse
      {
        $course = $CourseRepository->find($course);

        if(!$course) {
          throw $this->createNotFoundException('Course not found!');
        }

        return $this->json([
          'data' => $course,
        ]);
      }

      #[Route('/courses/{course}', name: 'courses_create', methods: ['POST'])]
      public function create(Request $request, CourseRepository $CourseRepository): JsonResponse
      {
        $data = $request->toArray();

        $course = new course();
        $course->setCategory($data['category']);
        $course->setStatus('Ativo');
        $course->setCreatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));
        $course->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $CourseCategoryRepository->save($course, true);

        return $this->json([
            'message' => 'Course created successfully',
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
      public function delete(int $course, Request $request, CourseRepository $CourseRepository): JsonResponse
      {
        $course = $CourseRepository->find($course);

        if(!$course) {
          throw $this->createNotFoundException('course not found!');
        }

        $course->setStatus('Inativo');
        $course->setUpdatedAt(new \DateTimeImmutable('now', new \DateTimeZone('America/Sao_Paulo')));

        $CourseRepository->save($course, true);

        return $this->json([
            'message' => 'Course delete successfully',
        ], 200);
      }
  }




