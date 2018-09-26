<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class ProductsRepository extends ServiceEntityRepository
{
    /** {@inheritdoc} */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }
}