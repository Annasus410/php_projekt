<?php
/**
 *  UserData fixtures.
 *
 */

namespace App\DataFixtures;

use App\Entity\UserData;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;




class UserDataFixtures extends Fixture

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
//            $userdata = new UserData();
//            $userdata->setName($this->faker->name);
//            $userdata->setLastname($this->faker->lastName);
//            $userdata->setMail($this->faker->email);
//            $userdata->setPhoneNumber($this->faker->randomFloat([0],[9]));
//            $userdata->setCity($this->faker->word);
//            $this-> manager->persist($userdata);
//        }
//
//        // $product = new Product();
//
//
//        $manager->flush();
    }
}
