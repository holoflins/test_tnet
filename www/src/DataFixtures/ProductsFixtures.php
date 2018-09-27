<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ProductsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $products = [
            ['name' => 'Pong', 'category' => $this->getReference('games'), 'sku' => 'A0001', 'price' => 69.99, 'quantity' => 20],
            ['name' => 'GameStation 5', 'category' => $this->getReference('games'), 'sku' => 'A0002', 'price' => 269.99, 'quantity' => 15],
            ['name' => 'AP Oman PC - Aluminum', 'category' => $this->getReference('computers'), 'sku' => 'A0003', 'price' => 1399.99, 'quantity' => 10],
            ['name' => 'Fony UHD HDR 55" 4k TV', 'category' => $this->getReference('tv'), 'sku' => 'A0004', 'price' => 1399.99, 'quantity' => 5],
        ];

        foreach($products as $data) {
            $product = new Products();
            $product->setName($data['name'])
                ->setCategory($data['category'])
                ->setSKU($data['sku'])
                ->setPrice($data['price'])
                ->setQuantity($data['quantity'])
            ;

            $manager->persist($product);
        }

        $manager->flush();
    }
}