<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Contact;
use App\Entity\Education;
use App\Entity\Experience;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $batchSize = 100;

        for ($i = 1; $i <= 100000; $i++) {
            $student = new Student();
            $student->setName('Student ' . $i);

            $address = new Address();
            $address->setLot('123 Main Street');
            $address->setCity('New York');
            $address->setCp('10001');
            $student->setAddress($address);

            $contact = new Contact();
            $contact->setPhone('123-456-7890');
            $contact->setEmail('student' . $i . '@example.com');
            $contact->setLinkedin('https://www.linkedin.com/in/student' . $i);
            $student->setContact($contact);

            $experience1 = new Experience();
            $experience1->setStartDate(new \DateTime('2021-01-01'));
            $experience1->setEndDate(new \DateTime('2023-06-30'));
            $experience1->setPost('Software Engineer');
            $student->addExperience($experience1);

            $education1 = new Education();
            $education1->setDiploma('Bachelor of Science in Computer Science');
            $education1->setDate(new \DateTime('2020-05-15'));
            $student->addEducation($education1);

            $manager->persist($experience1);
            $manager->persist($education1);

            $manager->persist($student);

            if ($i % $batchSize === 0) {
                $manager->flush();
                $manager->clear();
            }
        }

        $manager->flush();
        $manager->clear();
    }
}
