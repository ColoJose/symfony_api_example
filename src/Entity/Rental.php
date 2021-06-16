<?php

namespace App\Entity;

use App\Repository\RentalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentalRepository::class)
 */
class Rental {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $startContract;

    /**
     * @ORM\Column(type="date")
     */
    private $endContract;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartContract(): ?\DateTimeInterface
    {
        return $this->startContract;
    }

    public function setStartContract(\DateTimeInterface $startContract): self
    {
        $this->startContract = $startContract;

        return $this;
    }

    public function getEndContract(): ?\DateTimeInterface
    {
        return $this->endContract;
    }

    public function setEndContract(\DateTimeInterface $endContract): self
    {
        $this->endContract = $endContract;

        return $this;
    }
}

