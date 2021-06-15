<?php

namespace App\Entity;

use App\Repository\TenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TenantRepository::class)
 */
class Tenant extends Person {
    /**
     * @ORM\OneToOne(targetEntity=Rental::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $rental;

    public function getRental(): ?Rental
    {
        return $this->rental;
    }

    public function setRental(Rental $rental): self
    {
        $this->rental = $rental;

        return $this;
    }
}

