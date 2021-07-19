<?php


namespace App\Controller;

use App\Controller\Helper\ConstraintValidationFailErrorResponse;
use App\Service\PropertyService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;

/**
 * Class PropertyController
 * @package App\Controller
 * @Route("/property")
 */
class PropertyController extends ApiController
{
    private $propertyService;

    public function __construct(PropertyService $propertyService, SerializerInterface $serializer) {
        parent::__construct($serializer);
        $this->propertyService = $propertyService;
    }

    /**
     * @Route("",
     *        name="filter_properties",
     *        methods={"GET"},
     *        condition="request.query.get('location')"
     * )
     */
    public function filterByLocation(Request $request): Response {
        $properties = $this->propertyService->findBy(['location' => $request->query->get('location')]);
        $serialzedProperties = $this->serializer->serialize($properties, 'json');
        return JsonResponse::fromJsonString($serialzedProperties);
    }

    /**
     * @Route("", name="all_properties", methods={"GET"})
     */
    public function getAll(): Response {
        $serializedProperties = $this->serializer->serialize(
            $this->propertyService->findAll(),
            'json'
        );
        return JsonResponse::fromJsonString($serializedProperties);
    }

    /**
     * @Route("/{id}", name="get_property", methods={"GET"})
     */
    public function getProperty(int $id): Response {
        $property = $this->propertyService->find($id);

        if (!$property) {
            return $this->resourceNotFound($id);
        }

        $serializedProperty = $this->serializer->serialize(
            $property,
            'json'
        );
        return JsonResponse::fromJsonString($serializedProperty);
    }

    /**
     * @Route("/{id}", name="del_property", methods={"DELETE"})
     */
    public function delete(int $id): Response {
        $property = $this->propertyService->find($id);

        if (!$property) {
            return $this->resourceNotFound($id);
        }

        $this->propertyService->delete($property);
        return new Response("Property removed successfully");
    }

    /**
     * @Route("/{id}", name="update_property", methods={"PUT"})
     */
    public function update(int $id, Request $request): Response {
        $property = $this->propertyService->find($id);
        if (!$property) {
            return $this->resourceNotFound($id);
        }

        $dataDecode = $request->toArray();
        $this->propertyService->update($property,$dataDecode);

        return new Response("Successfully updated", 200);
    }

    /**
     * @Route("", name="create_property", methods={"POST"})
     */
    public function create(Request $request): Response {
        $propertyType = $request->query->get('type');
        $result = $this->propertyService->create($propertyType, $request->toArray());

        if ($result instanceof ConstraintViolationList) {
            return (new ConstraintValidationFailErrorResponse())->make($result);
        }

        return new Response("Succesfully Created", Response::HTTP_CREATED);
    }


}

