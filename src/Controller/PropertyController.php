<?php


namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class PropertyController
 * @package App\Controller
 * @Route("/property")
 */
class PropertyController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", name="all_properties", methods={"GET"})
     */
    public function getAllProperties(PropertyRepository $propertyRepository): JsonResponse {
        $serializedProperties = $this->serializer->serialize(
            $propertyRepository->findAll(),
            'json'
        );
        return JsonResponse::fromJsonString($serializedProperties);
    }
}

