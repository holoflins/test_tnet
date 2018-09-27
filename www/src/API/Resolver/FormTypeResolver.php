<?php

namespace App\API\Resolver;

use App\API\Exception\FormTypeNotFoundException;

class FormTypeResolver
{
    use ResolverTrait;

    private $formPath = 'App\\Form\\';

    /**
     * @param string $entityName
     *
     * @return string
     * @throws FormTypeNotFoundException
     */
    public function resolveFullNameFromName(string $entityName): string
    {
        $entityClassName = $this->toCamelCase($entityName.'Type');
        $entityNameSpace = sprintf('%s%s', $this->formPath, $entityClassName);

        if (!class_exists($entityNameSpace)) {
            throw new FormTypeNotFoundException(sprintf('Class %s was not found', $entityNameSpace));
        }

        return $entityNameSpace;
    }
}
