<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
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

    #[Route('/create', name: 'creating', methods: ["GET", "POST"])]
    public function createStudent(Request $request, StudentManager $studentManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $student = new Student();

        $form = $this->createForm(StudentType::class, $student);
        $form->submit($data);

        if($form->isSubmitted() && $form->isValid()) {
            $studentManager->saveStudent($student);

            return $this->json([
                'code' => Response::HTTP_CREATED,
                'status' => 'success'
            ]);
        }
        
        return $this->json($this->getFormErrors($form), Response::HTTP_BAD_REQUEST);
        
    }

    private function getFormErrors($form): array
    {
        $errors = [];

        foreach ($form->getErrors(true, true) as $error) {
            // Get the name of the form field that has the error
            $fieldName = $error->getOrigin()->getName();

            $errorMessage = $error->getMessage();

            $errors[$fieldName][] = $errorMessage;
        }

        foreach ($form->all() as $name => $child) {
            foreach ($child->getErrors(true, true) as $error) {
                $errors[$name][] = $error->getMessage();
            }
        }
    

        return $errors;
    }

    #[Route('/list/{page}', name: 'listing', methods: ['GET'], requirements: ['page' => '\d+'])]
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
