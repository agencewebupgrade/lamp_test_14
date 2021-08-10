<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// ADED BY ME
use App\Entity\Blog;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($count = 0; $count < 20; $count++) {
            $blog = new Blog();
            $blog->setName("Article " . $count);
            $blog->setImage("image" . $count . ".png");
            $manager->persist($blog);
        }

        $manager->flush();
    }
}
