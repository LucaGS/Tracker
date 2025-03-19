<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestRepository::class)]
class Test
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $testname = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestname(): ?string
    {
        return $this->testname;
    }

    public function setTestname(string $testname): static
    {
        $this->testname = $testname;

        return $this;
    }
}
