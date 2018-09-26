<?php

namespace App\API\Factory;

use App\API\Resolver\EntityResolver;
use App\Repository\RepositoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class RepositoryFactory
{
    /** @var EntityResolver */
    private $resolver;

    /** @var RegistryInterface */
    private $registry;

    /**
     * @param EntityResolver    $resolver
     * @param RegistryInterface $registry
     * @param Dispatcher        $dispatcher
     */
    public function __construct(EntityResolver $resolver, RegistryInterface $registry)
    {
        $this->resolver = $resolver;
        $this->registry = $registry;
    }

    /**
     * @param string $entityName
     *
     * @return RepositoryInterface
     * @throws \App\Exception\ApiKeyNotFoundException
     * @throws \App\Exception\EntityNotFoundException
     */
    public function create(string $entityName): RepositoryInterface
    {
        $entityNameSpace = $this->resolver->resolveFullNameFromName($entityName);

        return $this->registry->getRepository($entityNameSpace);
    }
}