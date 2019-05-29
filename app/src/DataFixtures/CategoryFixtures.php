<?php
/**
 *  Category fixtures.
 *
 */

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;




class CategoryFixtures extends Fixture

{
    /**
     * Faker.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Object manager.
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * Load.
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();
        $this->manager = $manager;

        for( $i = 0; $i < 10; ++$i )
        {

            $category = new Category();
            $category->setCategoryName($this->faker->word);
            $this-> manager->persist($category);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
