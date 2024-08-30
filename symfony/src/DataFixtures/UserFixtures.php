<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures   extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('admin@newtrick.com');
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user->setVerified(true);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $_ENV['ADMIN_PW']);
        $user->setPassword($hashedPassword);

        $manager->persist($user);
        $manager->flush();
    }
}