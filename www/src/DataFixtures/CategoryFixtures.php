<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categoriesName = ['games' => 'Games', 'computers' => 'Computers', 'tv' => 'TVs and Accessories'];

        foreach($categoriesName as $key => $value) {
            $category = new Category();
            $category->setName($value);

            $this->addReference($key, $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}