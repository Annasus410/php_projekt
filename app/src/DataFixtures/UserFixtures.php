<?php
/**
 *  User fixtures.
 *
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;




class UserFixtures extends Fixture

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

            $user = new User();
            $user->setLogin($this->faker->name);
            $user->setPassword($this->faker->password);
            $user->setRole($this->faker->word);
            $this-> manager->persist($user);
        }

        // $product = new Product();


        $manager->flush();
    }
}
