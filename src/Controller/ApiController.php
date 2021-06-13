<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class ApiController extends AbstractController
{
    protected function resourceNotFound($id): Response {
        return new Response(sprintf("Resource with id: %d was not found", $id), 404);
    }
}