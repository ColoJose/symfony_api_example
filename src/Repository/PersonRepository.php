<?php

namespace App\Repository;

use App\Constant;
use App\Entity\Person;
use App\Entity\Rental;
use App\Entity\Tenant;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends AbstractRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Person::class);
    }

    public function create(string $type, $data) {
        if ( $type == Constant::VALID_TYPE_PERSON[0]) {
            $this->createTenant($data);
        }
    }

    private function createTenant($data) {
        $tenant = new Tenant();
        $this->setCommonProperties($tenant, $data);
        $rental = $this->createRental($data['rental']);
        $tenant->setRental($rental);

        $this->insert($tenant);
    }

    /**
     * Set the properties which are common to any subclass of Person
     * @param $person
     * @param $data
     */
    private function setCommonProperties($person, $data) {
        /** @var Person $person */
        $person->setName($data['name']);
        $person->setSurname($data['surname']);

        if (isset($data['phone'])) {
            $person->setPhone($data['phone']);
        }
    }

    private function createRental($data) {
        $rental = new Rental();
        $rental->setStartContract(
            new \DateTime($data['start_contract'])
        );
        $rental->setEndContract(
            new \DateTime($data['end_contract'])
        );
        return $rental;
    }
}

