<?php

namespace App\Entity;

use App\Repository\StartedtrainingRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StartedtrainingRepository::class)]
class Startedtraining
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $userid = null;

    #[ORM\Column]
    private ?int $trainingplanid = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTrainingplanid(): ?int
    {
        return $this->trainingplanid;
    }

    public function setTrainingplanid(int $trainingplanid): static
    {
        $this->trainingplanid = $trainingplanid;

        return $this;
    }
}
