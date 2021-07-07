<?php

namespace App\Entity;

use App\Repository\HouseRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HouseRepository::class)
 */
class House extends Property
{

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $floors;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasGarden;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive
     */
    private $gardenSqm;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFloors(): ?int
    {
        return $this->floors;
    }

    public function setFloors(int $floors): self
    {
        $this->floors = $floors;

        return $this;
    }

    public function getHasGarden(): ?bool
    {
        return $this->hasGarden;
    }

    public function setHasGarden(bool $hasGarden): self
    {
        $this->hasGarden = $hasGarden;

        return $this;
    }

    public function getGardenSqm(): ?int
    {
        return $this->gardenSqm;
    }

    public function setGardenSqm(?int $gardenSqm): self
    {
        $this->gardenSqm = $gardenSqm;

        return $this;
    }
}

