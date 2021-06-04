<?php


namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PropertyController
 * @package App\Controller
 * @Route("/property")
 */
class PropertyController extends AbstractController
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
     * @Route("/", name="all_properties", methods={"GET"})
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
        $property = $this->serializer->serialize(
            $this->propertyRepository->find($id),
            'json'
        );
        return JsonResponse::fromJsonString($property);
    }

}

