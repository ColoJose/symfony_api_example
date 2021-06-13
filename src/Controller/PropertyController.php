<?php


namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PropertyController
 * @package App\Controller
 * @Route("/property")
 */
class PropertyController extends ApiController
{
    private $serializer;
    private $entityManager;
    private $propertyRepository;

    public function __construct(SerializerInterface $serializer,
                                EntityManagerInterface $entityManager,
                                PropertyRepository $propertyRepository) {
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * @Route("", name="all_properties", methods={"GET"})
     */
    public function getAllProperties(): JsonResponse {
        $serializedProperties = $this->serializer->serialize(
            $this->propertyRepository->findAll(),
            'json'
        );
        return JsonResponse::fromJsonString($serializedProperties);
    }

    /**
     * @Route("/{id}", name="get_property", methods={"GET"})
     */
    public function getProperty(int $id) {
        $property = $this->propertyRepository->find($id);

        if (!$property) {
            return $this->resourceNotFound($id);
        }

        $property = $this->serializer->serialize(
            $this->propertyRepository->find($id),
            'json'
        );
        return JsonResponse::fromJsonString($property);
    }

    /**
     * @Route("/{id}", name="del_property", methods={"DELETE"})
     */
    public function deleteProperty(int $id): Response {
        $property = $this->propertyRepository->find($id);

        if (!$property) {
            return $this->resourceNotFound($id);
        }

        $this->entityManager->remove($property);
        $this->entityManager->flush();
        return new JsonResponse('Property removed successfully ');
    }

    /**
     * @Route("/{id}", name="update_property", methods={"PUT"})
     */
    public function updateProperty(int $id, Request $request): Response {
        $property = $this->propertyRepository->find($id);

        if (!$property) {
            return $this->resourceNotFound($id);
        }

        $data_decode = $request->toArray();
        $this->propertyRepository->update($property,$data_decode);

        return new JsonResponse("Successfully updated", 200);
    }

    /**
     * @Route("", name="create_property", methods={"POST"})
     */
    public function create(Request $request): Response {
        $property_type = $request->query->get('type');
        $data_decode = $request->toArray();

        $this->propertyRepository->create($property_type, $data_decode);

        return new Response("Succesfully Created", Response::HTTP_CREATED);
    }
}

