<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Manager\StudentManager;
use App\Repository\StudentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/student')]
class StudentController extends AbstractController
{
    #[Route('/', name: 'app_student_index', methods: ['GET'])]
    public function index(Request $request, PaginatorInterface $paginator, StudentRepository $studentRepository): Response
    {
        $allStudentsQuery = $studentRepository->createQueryBuilder('s')->getQuery();

        $students = $paginator->paginate(
            $allStudentsQuery,
            $request->query->getInt('page', 1), // Current page number, default is 1
            10 // Number of items per page
        );

        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/new', name: 'app_student_new', methods: ['GET', 'POST'])]
    public function new(Request $request, StudentManager $studentManager): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentManager->saveStudent($student);

            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student/new.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{uid}', name: 'app_student_show', methods: ['GET'])]
    public function show(Student $student): Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route('/{uid}/edit', name: 'app_student_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Student $student, StudentManager $studentManager): Response
    {
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentManager->saveStudent($student);
            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student/edit.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/{uid}', name: 'app_student_delete', methods: ['POST'])]
    public function delete(Request $request, Student $student, StudentManager $studentManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$student->getUid(), $request->request->get('_token'))) {
            $studentManager->deleteStudent($student);
        }

        return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
    }
}
