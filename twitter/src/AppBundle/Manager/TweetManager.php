<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 10/03/2017
 * Time: 10:43.
 */

namespace AppBundle\Manager;

use AppBundle\Entity\tweet;
use Doctrine\ORM\EntityManagerInterface;

class TweetManager
{
    private $entityManager;
    private $nbLast;

    public function __construct(EntityManagerInterface $entityManager, $nbLast)
    {
        $this->entityManager = $entityManager;
        $this->nbLast = $nbLast;
    }

    public function create()
    {
        return new tweet();
    }

    public function save(tweet $tweet)
    {
        $this->entityManager->persist($tweet);
        $this->entityManager->flush();
    }

    public function getLast()
    {
        return $this->getrepository()->getLastTweets($this->nbLast);
        //$tweets = $this->getDoctrine()->getRepository(Tweet::class)->getLastTweets($this->getParameter('app_tweet_nb_last', 10));
    }

    private function getrepository()
    {
        return $this->entityManager->getRepository(Tweet::class);
    }
}
