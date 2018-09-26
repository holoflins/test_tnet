<?php

namespace App\API\Resolver;

use App\API\Exception\EntityNotFoundException;

class EntityResolver
{
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

    /**
     * Change property to camel case for methods
     *
     * @param string $property
     *
     * @return string
     */
    private function toCamelCase(string $property): string
    {
        return ucfirst(
            preg_replace_callback(
                '/[_-](.)/',
                function ($match) {
                    return strtoupper($match[1]);
                },
                $property
            )
        );
    }
}