<?php

namespace App\Repository;

use App\Entity\Flat;
use App\Entity\House;
use App\Entity\Property;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function update(Property $property, $data_decode )
    {
        /**
         * @var string $street
         * @var float $sqm
         * @var string $location
         * @var int $number
         * @var int $zipCode
         */
        extract($data_decode);
        if (isset($street)) { $property->setStreet($street); };
        if (isset($sqm)) { $property->setSqm($sqm); };
        if (isset($number)) { $property->setNumber($number); };
        if (isset($zipCode)) { $property->setZipCode($zipCode); };

        $this->insert($property);
    }

    public function create(string $propertyType, $data) {
        if ($propertyType == 'flat') { $this->createFlat($data); };
        if ($propertyType == 'house') { $this->createHouse($data); };
    }

    /**
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createFlat($data) {
        $house = new Flat();
        $this->setCommonProperties($house, $data);
        $house->setIsLoft($data['isLoft']);
        $house->setAcceptPets($data['acceptPets']);
        $this->insert($house);
    }

    /**
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createHouse($data) {
        $house = new House();
        $this->setCommonProperties($house, $data);
        $house->setFloors($data['floors']);
        $house->setHasGarden($data['hasGarden']);
        if ($data['hasGarden']) {
            $house->setGardenSqm($data['gardenSqm']);
        }
        $this->insert($house);
    }

    private function setCommonProperties($property, $data) {
        /** @var  Property $property */
        $property->setStreet($data['street']);
        $property->setNumber($data['number']);
        if ($data['zipCode']) {
            $property->setZipCode($data['zipCode']);
        }
        $property->setSqm($data['sqm']);
        $property->setLocation($data['location']);
    }
}
