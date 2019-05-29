<?php
/**
 *  Photo fixtures.
 *
 */

namespace App\DataFixtures;

use App\Entity\Opinion;
use App\Entity\Photo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;




class PhotoFixtures extends Fixture

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
//        {
//
//            $photo = new Photo();
//            $photo->setPhotoName($this->faker->sentence);
//
//            $this-> manager->persist($photo);
//
//        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
