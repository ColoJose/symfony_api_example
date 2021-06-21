<?php


namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PersonController
 * @package App\Controller
 * @Route("/person")
 */
class PersonController extends ApiController {

    private $personRepository;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer) {
        parent::__construct($em, $serializer);
        $this->personRepository = $this->em->getRepository(Person::class);
    }

    /**
     * @Route("", name="all_people", methods={"GET"})
     */
    public function getAll(): JsonResponse {
        $serializedPeople = $this->serializer->serialize(
            $this->personRepository->findAll(), 'json'
        );

        return JsonResponse::fromJsonString($serializedPeople);
    }
}
