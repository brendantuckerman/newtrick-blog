<?php

namespace App\DataFixtures;

use App\Entity\Teacher;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TeacherFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       $teacher = new Teacher();
       $teacher->setFirstName('Brendan');
       $teacher->setLastName('Tuckerman');
       $teacher->setImagePath('https://placeholder.pics/svg/300');
       $manager->persist($teacher);

       $teacher2 = new Teacher();
       $teacher2->setFirstName('Sally');
       $teacher2->setLastName('Smith');
       $teacher2->setImagePath('https://placeholder.pics/svg/300');
       $manager->persist($teacher2);

       $manager->flush();
    }

}
