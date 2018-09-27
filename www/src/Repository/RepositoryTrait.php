<?php

namespace App\Repository;

use App\Entity\EntityInterface;

trait RepositoryTrait
{
    public function save(EntityInterface $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function delete(EntityInterface $entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}