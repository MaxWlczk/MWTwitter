<?php

namespace AppBundle\Controller;

use AppBundle\Entity\tweet;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TweetController extends Controller
{
    /**
     * @Route("/", name="app_tweet_list")
     */
    public function listAction(Request $request)
    {
        $tweets = $this->getDoctrine()->getRepository(Tweet::class)->getLastTweets($this->getParameter('app_tweet_nb_last', 10));

        return $this->render(':tweet:list.html.twig', [
            'tweets' => $tweets,
        ]);
    }
}
