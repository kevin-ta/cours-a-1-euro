<?php

namespace Zephyr\CoursBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Zephyr\CoursBundle\Entity\Course;


class LoadCategory implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $subject ='Mathématiques';

        $unit ='SFM2001';

        $date ='2000-01-01 01:01:01';

        $course = new Course();
        $course->setSubject($subject);
        $course->setUnit($unit);
        $course->setDate(new \DateTime($date));
        $manager->persist($course);
        $manager->flush();
    }
}