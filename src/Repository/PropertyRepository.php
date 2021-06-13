<?php

namespace App\Repository;

use App\Entity\Flat;
use App\Entity\House;
use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
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

        $this->getEntityManager()->persist($property);
        $this->getEntityManager()->flush();
    }

    public function create(string $propertyType, $data) {
        if ($propertyType == 'flat') { $this->createFlat($data); };
        if ($propertyType == 'house') { $this->createHouse($data); };
    }

    private function createFlat($data) {
        $house = new Flat();
        $this->setCommonProperties($house, $data);
        $house->setIsLoft($data['isLoft']);
        $house->setAcceptPets($data['acceptPets']);
        $this->persist($house);
    }

    private function createHouse($data) {
        $house = new House();
        $this->setCommonProperties($house, $data);
        $house->setFloors($data['floors']);
        $house->setHasGarden($data['hasGarden']);
        if ($data['hasGarden']) {
            $house->setGardenSqm($data['gardenSqm']);
        }
        $this->persist($house);
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

    public function persist(Property $property) {
        $this->getEntityManager()->persist($property);
        $this->getEntityManager()->flush();
    }
}
