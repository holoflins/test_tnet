<?php

namespace App\API\Resolver;

trait ResolverTrait
{
    /**
     * Change property to camel case for methods
     *
     * @param string $property
     *
     * @return string
     */
    public function toCamelCase(string $property): string
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