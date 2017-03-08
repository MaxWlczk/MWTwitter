<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Tweet;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTweetData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $messages = [
            'hello world',
            'symfony its cool',
            'blblblblblblblblblblblblbl',
            'vive les roux',
            'kawabunga',
            'arsenal 2 - 10 bayern',
            'ouille',
            'moche',
            'Timothée le castor',
        ];
        foreach ($messages as $i => $message) {
            $tweet = new Tweet();
            $tweet->setMessage($message);
            $manager->persist($tweet);
            $this->addReference('tweet-'.$i, $tweet);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
