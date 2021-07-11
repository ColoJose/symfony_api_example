<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DebtorsController
 * @package App\Controller
 * @Route("/debtors")
 */
class DebtorsController extends ApiController {

    private $connection;

    /**
     * @Route("", name="get_debtors", methods={"GET"})
     */
    public function getDebtors() {

        $this->connection = $this->getDoctrine()->getConnection('debtors_register');

        $debtors = $this->serializer->serialize(
                        $this->connection->fetchAll('SELECT * FROM debtors'),
                        'json'
                   );

        return JsonResponse::fromJsonString($debtors);
    }
}

