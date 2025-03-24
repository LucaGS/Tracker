<?php

namespace App\Entity;

use App\Repository\ExcerciseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExcerciseRepository::class)]
class Excercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $sets = null;

    #[ORM\Column]
    private ?int $trainingplanid = null;

    #[ORM\Column]
    private ?int $userid = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSets(): ?int
    {
        return $this->sets;
    }

    public function setSets(int $sets): static
    {
        $this->sets = $sets;

        return $this;
    }

    public function getTrainingplanid(): ?int
    {
        return $this->trainingplanid;
    }

    public function setTrainingplanid(int $trainingplanid): static
    {
        $this->trainingplanid = $trainingplanid;

        return $this;
    }

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function setUserid(int $userid): static
    {
        $this->userid = $userid;

        return $this;
    }
}
