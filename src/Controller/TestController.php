<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TestController
{
    /**
     * @Route("/test", name="test")
     */
    public function foo(): Response
    {
        return new Response('<html><body>It works 2</body></html>');
    }
}