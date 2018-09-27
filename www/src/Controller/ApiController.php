<?php

namespace App\Controller;

use App\API\Factory\RepositoryFactory;
use App\API\Writer\EntityWriter;
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

    /**
     * @param string $entityName
     * @param string $id
     * @param RepositoryFactory $repositoryFactory
     * @param Request $request
     * @return JsonResponse
     */
    public function getOne(string $entityName, string $id, RepositoryFactory $repositoryFactory): JsonResponse
    {
        $repository = $repositoryFactory->create($entityName);

        return $this->json($repository->find($id), JsonResponse::HTTP_OK);
    }

    /**
     * @param string $entityName
     * @param EntityWriter $entityWriter
     * @return JsonResponse
     */
    public function create(string $entityName, EntityWriter $entityWriter): JsonResponse
    {
        return $this->json($entityWriter->write($entityName), JsonResponse::HTTP_CREATED);
    }

    /**
     * @param string $entityName
     * @param string $id
     * @param EntityWriter $entityWriter
     * @return JsonResponse
     */
    public function update(string $entityName, string $id, EntityWriter $entityWriter): JsonResponse
    {
        return $this->json($entityWriter->write($entityName, $id), JsonResponse::HTTP_OK);
    }

    /**
     * @param string $entityName
     * @param string $id
     * @param EntityWriter $entityWriter
     * @return JsonResponse
     */
    public function delete(string $entityName, string $id, EntityWriter $entityWriter): JsonResponse
    {
        return $this->json($entityWriter->delete($entityName, $id), JsonResponse::HTTP_NO_CONTENT);
    }
}