<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;

/**
 * @ORM\Entity(repositoryClass=PropertyRepository::class)
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"house" = "House", "flat" = "Flat"})
 */
abstract class Property
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="float")
     */
    private $sqm;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasGarden;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(?int $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getSqm(): ?float
    {
        return $this->sqm;
    }

    public function setSqm(float $sqm): self
    {
        $this->sqm = $sqm;

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

    public function getLocation(): ?string
    {
        return $this->Location;
    }

    public function setLocation(string $Location): self
    {
        $this->Location = $Location;

        return $this;
    }

    final public function getAddress(): string
    {
        return $this->getStreet() . " " . $this->getNumber() . ", " . $this->getLocation();
    }
}
