<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function getDebtors(Request $request, EntityManagerInterface $entityManager) {

        $ssn = $request->query->get('ssn');
        $this->connection = $this->getDoctrine()->getConnection('debtors_register');

        $sql = "SELECT * FROM debtors WHERE ssn = ?";
        $result = $this->connection->executeQuery($sql, array($ssn));
        
        return JsonResponse::fromJsonString($this->serializer->serialize($result, 'json'));
    }
}

