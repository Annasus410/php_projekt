<?php
/**
 *  Announcement fixtures.
 *
 */

namespace App\DataFixtures;

use App\Entity\Announcement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;




class AnnouncementFixtures extends Fixture

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

            $announcement = new Announcement();
            $announcement->setId($this->faker->numberBetween([0], [300]));
            $announcement->setTitle($this->faker->sentence);
            $announcement->setContent($this->faker->sentence);
            $announcement->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $announcement->setAccepted($this->faker->boolean);
            $announcement->setComments($this->faker->sentence);
            $announcement->setCategories($this->faker->sentence());
            $announcement->setUser($this->faker->sentence());
            $announcement->setPhoto($this->faker->sentence());

            $this-> manager->persist($announcement);
        }


        $manager->flush();
    }
}
