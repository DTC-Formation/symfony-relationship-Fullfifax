<?php

namespace App\Manager;

use App\Entity\Student;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Style\SymfonyStyle;

class StudentManager {
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function saveStudent(Student $student): void
    {
        foreach($student->getExperiences() as $experience) {
            $this->entityManager->persist($experience);
        }

        foreach($student->getEducations() as $education) {
            $this->entityManager->persist($education);
        }

        $this->entityManager->persist($student);
        $this->entityManager->flush();
    }

    public function deleteStudent(Student $student): void
    {
        $this->entityManager->remove($student);
        $this->entityManager->flush();
    }

    public function generateSuperAdmin(SymfonyStyle $style, string $adminName)
    {
        $student = new Student();
        
        $student->setName($adminName);

        $this->saveStudent($student);

        $style->success(sprintf("Admin student's name: %s", $student->getName()));
    }
}