<?php

namespace App\Entity;

use App\Repository\FlatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FlatRepository::class)
 */
class Flat extends Property
{
    /**
     * @ORM\Column(type="boolean")
     */
    private $acceptPets;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLoft;

    public function getAcceptPets(): ?bool
    {
        return $this->acceptPets;
    }

    public function setAcceptPets(bool $acceptPets): self
    {
        $this->acceptPets = $acceptPets;

        return $this;
    }

    public function getIsLoft(): ?bool
    {
        return $this->isLoft;
    }

    public function setIsLoft(bool $isLoft): self
    {
        $this->isLoft = $isLoft;

        return $this;
    }
}

