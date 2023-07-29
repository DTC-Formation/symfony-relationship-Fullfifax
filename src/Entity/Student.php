<?php

namespace App\Entity;

use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\Column(type:"uuid", unique:true)]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    #[Groups('listing')]
    private ?Uuid $uid;

    #[ORM\Column(length: 255)]
    #[Groups(['listing', 'details'])]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'student', cascade: ['persist', 'remove'])]
    #[Groups('listing')]
    private ?Address $address = null;

    #[ORM\OneToOne(mappedBy: 'student', cascade: ['persist', 'remove'])]
    #[Groups('listing')]
    private ?Contact $contact = null;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Experience::class, orphanRemoval: true)]
    #[Groups('listing')]
    private Collection $experiences;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: Education::class, orphanRemoval: true)]
    private Collection $educations;

    public function __construct()
    {
        $this->uid = Uuid::v4();
        $this->experiences = new ArrayCollection();
        $this->educations = new ArrayCollection();
    }

    public function getUid(): ?Uuid
    {
        return $this->uid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): static
    {
        // set the owning side of the relation if necessary
        if ($address->getStudent() !== $this) {
            $address->setStudent($this);
        }

        $this->address = $address;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(Contact $contact): static
    {
        // set the owning side of the relation if necessary
        if ($contact->getStudent() !== $this) {
            $contact->setStudent($this);
        }

        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): static
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
            $experience->setStudent($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): static
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getStudent() === $this) {
                $experience->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Education>
     */
    public function getEducations(): Collection
    {
        return $this->educations;
    }

    public function addEducation(Education $education): static
    {
        if (!$this->educations->contains($education)) {
            $this->educations->add($education);
            $education->setStudent($this);
        }

        return $this;
    }

    public function removeEducation(Education $education): static
    {
        if ($this->educations->removeElement($education)) {
            // set the owning side to null (unless already changed)
            if ($education->getStudent() === $this) {
                $education->setStudent(null);
            }
        }

        return $this;
    }

}
