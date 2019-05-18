<?php
/**
 * Task fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Announcement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class TaskFixtures.
 */
class TaskFixtures extends Fixture
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

        for ($i = 0; $i < 10; ++$i) {
            $task = new Announcement();
            $task->setTitle($this->faker->sentence);
            $task->setContent($this->faker->sentence);
            $task->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
//            $task->setCategory($this->faker->integer(0,4));
            $this->manager->persist($task);
        }

        $manager->flush();
    }
}