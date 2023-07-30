<?php

namespace App\Controller;

use App\Entity\Student;
use App\Helper\JsonResponseHelper;
use App\Manager\StudentManager;
use App\Repository\StudentRepository;
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

    public function __construct(StudentRepository $studentRepository, JsonResponseHelper $jsonResponseHelper)
    {
        $this->jsonResponseHelper = $jsonResponseHelper;
        $this->studentRepository = $studentRepository;
    }

    #[Route('/create', name: 'creating', methods: ["POST"])]
    public function createStudent(Request $request, StudentManager $studentManager): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $studentManager->saveStudent($student);
        }

        return $this->renderForm('student/new.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/list/{page}', name: 'listing', requirements: ['page' => '\d+'])]
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
}
