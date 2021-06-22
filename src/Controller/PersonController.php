<?php


namespace App\Controller;

use App\Entity\Person;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * @Route("/{id}", name="get_person", methods={"GET"})
     */
    public function getPerson(int $id) {
        $person = $this->personRepository->find($id);
        if (!$person) {
            return $this->resourceNotFound($id);
        }

        $serializedPerson = $this->serializer->serialize(
            $person, 'json'
        );
        return JsonResponse::fromJsonString($serializedPerson);
    }

    /**
     * @Route("", name="create_person", methods={"POST"})
     */
    public function create(Request $request) {
        $type = $request->query->get('type');
        $body_to_array = $request->toArray();

        $this->personRepository->create($type, $body_to_array);

        return new JsonResponse("Succesfully Created", Response::HTTP_CREATED);

    }
}
