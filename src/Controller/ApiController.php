<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ApiController extends AbstractController
{

    protected $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    protected function resourceNotFound($id): Response {
        return new Response(sprintf("Resource with id: %d was not found", $id), 404);
    }
}

