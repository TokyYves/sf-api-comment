<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();


        for ($i=0; $i < 5; $i++) { 
            $user = new User();
            $user->setEmail($faker->email());
            $user->setPassword($this->userPasswordHasher->hashPassword($user,'password'));
            $manager->persist($user);
            for ($j=0; $j < random_int(1,5); $j++) { 
                $post = new Post();
                $post->setContent($faker->paragraph())
                    ->setAuthor($user);
                    $manager->persist($post);
                    for ($a=0; $a < random_int(0,4); $a++) { 
                        $comment = new Comment();
                        $comment->setContent($faker->sentence(5))
                                ->setAuthor($user)
                                ->setPost($post);
                        $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
