<?php

namespace App\Repository;

use App\Entity\EntityInterface;
use Doctrine\Common\Persistence\ObjectRepository;

interface RepositoryInterface extends ObjectRepository
{
    /**
     * @param EntityInterface $entitys
     */
    public function save(EntityInterface $entity): void;

    /**
     * @param EntityInterface $entity
     */
    public function delete(EntityInterface $entity): void;
}