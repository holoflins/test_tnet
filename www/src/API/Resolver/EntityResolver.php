<?php

namespace App\API\Resolver;

use App\API\Exception\EntityNotFoundException;

class EntityResolver
{
    use ResolverTrait;

    /** @var string */
    private $entityPath = 'App\\Entity\\';

    /**
     * @param string $entityName
     *
     * @return string
     * @throws EntityNotFoundException
     */
    public function resolveFullNameFromName(string $entityName): string
    {
        $entityNameSpace = sprintf('%s%s', $this->entityPath, $this->toCamelCase($entityName));

        if (!class_exists($entityNameSpace)) {
            throw new EntityNotFoundException(sprintf('Class %s was not found', $entityNameSpace));
        }

        return $entityNameSpace;
    }
}