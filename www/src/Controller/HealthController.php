<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HealthController extends Controller
{
    /**
     * HealthCheck to monitor this application for an other one
     *
     * @return Response
     */
    public function health(): Response
    {
        return $this->json(['status' => 'OK'], Response::HTTP_OK);
    }
}