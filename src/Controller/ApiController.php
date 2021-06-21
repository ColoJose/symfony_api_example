<?php


namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

abstract class ApiController extends AbstractController
{

    protected $em;
    protected $serializer;

    public function __construct(EntityManagerInterface $em, SerializerInterface $serializer) {
        $this->em = $em;
        $this->serializer = $serializer;
    }

    protected function resourceNotFound($id): Response {
        return new Response(sprintf("Resource with id: %d was not found", $id), 404);
    }
}