<?php

namespace App\Controller;

use App\API\Factory\RepositoryFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @param string $entityName
     * @param RepositoryFactory $repositoryFactory
     * @param Request $request
     * @return JsonResponse
     */
    public function list(string $entityName, RepositoryFactory $repositoryFactory, Request $request): JsonResponse
    {
        $repository =  $repositoryFactory->create($entityName);
        $list = $repository->findBy(
            json_decode($request->query->get('filter', '{}'), true),
            json_decode($request->query->get('orderBy', '{}'), true),
            json_decode($request->query->get('limit', null), true),
            json_decode($request->query->get('offset', null), true)
        );

        return $this->json($list, JsonResponse::HTTP_OK);
    }
}