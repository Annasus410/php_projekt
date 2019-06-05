<?php
/**
 *  Opiniom fixtures.
 *
 */

namespace App\DataFixtures;

use App\Entity\Opinion;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;




class OpinionFixtures extends Fixture

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
//        $this->faker = Factory::create();
//        $this->manager = $manager;
//
//        for( $i = 0; $i < 10; ++$i )
//        {
//
//            $opinion = new Opinion();
//            $opinion->setContent($this->faker->sentence);
//            $opinion->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
//            $opinion->setAuthor($this->faker->sentence);
//            $this-> manager->persist($opinion);
//
//        }
//
//        // $product = new Product();
//        // $manager->persist($product);
//
//        $manager->flush();
    }
}
