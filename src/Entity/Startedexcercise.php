<?php

namespace App\Entity;

use App\Repository\StartedexcerciseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StartedexcerciseRepository::class)]
class Startedexcercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $startedtrainingplanid = null;

    #[ORM\Column]
    private ?int $excerciseid = null;

    #[ORM\Column]
    private ?int $trainingplanid = null;

    #[ORM\Column]
    private ?int $userid = null;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $weight = null;

    #[ORM\Column]
    private ?int $set = null;

    #[ORM\Column]
    private ?int $reps = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedtrainingplanid(): ?int
    {
        return $this->startedtrainingplanid;
    }

    public function setStartedtrainingplanid(int $startedtrainingplanid): static
    {
        $this->startedtrainingplanid = $startedtrainingplanid;

        return $this;
    }

    public function getExcerciseid(): ?int
    {
        return $this->excerciseid;
    }

    public function setExcerciseid(int $excerciseid): static
    {
        $this->excerciseid = $excerciseid;

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

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getSet(): ?int
    {
        return $this->set;
    }

    public function setSet(int $set): static
    {
        $this->set = $set;

        return $this;
    }

    public function getReps(): ?int
    {
        return $this->reps;
    }

    public function setReps(int $reps): static
    {
        $this->reps = $reps;

        return $this;
    }
}
