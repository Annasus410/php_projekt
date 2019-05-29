<?php
/**
 *  Comment fixtures.
 *
 */

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;




class CommentFixtures extends Fixture

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

           $comment = new Comment();
           $comment->setCommentContent($this->faker->sentence);
           $comment->setCommentContent($this->faker->dateTimeBetween('-100 days', '-1 days'));
           $this-> manager->persist($comment);

        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
