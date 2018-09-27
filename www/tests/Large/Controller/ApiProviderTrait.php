<?php

namespace App\Tests\Large\Controller;

trait ApiProviderTrait
{
    public function providerList(): array
    {
        return [
            ['products'],
            ['category'],
        ];
    }
}