<?php

namespace App\API\Factory;

use App\API\Resolver\EntityResolver;

class EntityFactory
{
    /**
     * @var EntityResolver
     */
    private $resolver;

    /**
     * @param EntityResolver $resolver
     */
    public function __construct(EntityResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param string $entityName
     *
     * @return mixed
     * @throws \App\Exception\EntityNotFoundException
     */
    public function create(string $entityName)
    {
        $entityNameSpace = $this->resolver->resolveFullNameFromName($entityName);

        return new $entityNameSpace();
    }
}
