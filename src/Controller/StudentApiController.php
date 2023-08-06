<?php

namespace App\Controller;

use App\Entity\Student;
use App\Helper\JsonResponseHelper;
use App\Manager\StudentManager;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/student', name: 'app_student_')]
class StudentApiController extends AbstractController
{
    private $jsonResponseHelper;
    private $studentRepository;
    private $entityManager;

    public function __construct(StudentRepository $studentRepository, JsonResponseHelper $jsonResponseHelper, EntityManagerInterface $entityManager)
    {
        $this->jsonResponseHelper = $jsonResponseHelper;
        $this->studentRepository = $studentRepository;
        $this->entityManager  = $entityManager;
    }

    #[Route('/create', name: 'creating', methods: ["GET", "POST"])]
    public function createStudent(Request $request): Response
    {

        $student = $this->jsonResponseHelper
            ->configureSerializer(['listing'])
            ->deserialize($request->getContent(), Student::class, 'json');

        $this->entityManager->persist($student);
        $this->entityManager->flush();
        
        return $this->json([
            'message' => "success",
        ]);
        
    }

    #[Route('/list/page={page}', name: 'listing', methods: ['GET'], requirements: ['page' => '\d+'])]
    public function listStudents(?int $page = 1): JsonResponse
    {
        $students = $this->studentRepository->findBy([], [], $page * 10);

        return $this->json(
            [
                'data' => $this->jsonResponseHelper->serializeData($students, ['listing']),
                'code' => Response::HTTP_OK,
                'status' => 'success'
            ]
        );
    }

    #[Route('/edit/{uid}', name: 'editing', methods: ['GET', 'PUT'])]
    public function editStudent(Request $request, string $uid):  Response
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->findOneBy(['uid' => Uuid::fromString($uid)]);

        if(!$student) {
            return $this->json(['error' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        $student = $this->jsonResponseHelper
            ->configureSerializer(['listing'])
            ->deserialize($data, Student::class, 'json');

        $this->entityManager->persist($student);
        $this->entityManager->flush();

        return $this->json([
            'code' => Response::HTTP_OK,
            'status' => 'success',
        ]);

    }

    #[Route('/delete/{uid}', name: 'deleting', methods:['DELETE'])]
    public function deleteStudent(string $uid, StudentManager $studentManager)
    {
        $student = $this->getDoctrine()->getRepository(Student::class)->findOneBy(['uid' => Uuid::fromString($uid)]);

        if(!$student) {
            return $this->json(['error' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }

        $studentManager->deleteStudent($student);

        return $this->json([
            'code' => Response::HTTP_OK,
            'status' => 'success',
        ]);
    }
}
