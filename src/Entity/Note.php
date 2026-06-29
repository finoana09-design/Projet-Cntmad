<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NoteRepository::class)
 */
class Note
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Partielle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Final;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Student;

    /**
     * @ORM\ManyToOne(targetEntity=Matiere::class, inversedBy="notes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Matieres;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartielle(): ?string
    {
        return $this->Partielle;
    }

    public function setPartielle(?string $Partielle): self
    {
        $this->Partielle = $Partielle;

        return $this;
    }

    public function getFinal(): ?string
    {
        return $this->Final;
    }

    public function setFinal(?string $Final): self
    {
        $this->Final = $Final;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->Student;
    }

    public function setStudent(?Student $Student): self
    {
        $this->Student = $Student;

        return $this;
    }

    public function getMatieres(): ?Matiere
    {
        return $this->Matieres;
    }

    public function setMatieres(?Matiere $Matieres): self
    {
        $this->Matieres = $Matieres;

        return $this;
    }
}
