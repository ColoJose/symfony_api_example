<?php

namespace App\Repository;

use App\Entity\House;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method House|null find($id, $lockMode = null, $lockVersion = null)
 * @method House|null findOneBy(array $criteria, array $orderBy = null)
 * @method House[]    findAll()
 * @method House[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HouseRepository extends AbstractRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, House::class);
    }

}

